$(document).ready(function () {
    //Navigation entre les volets Données et Statistiques
    $("#data").on("click",function (){
        $("#statisticsSelection").hide();
        $("#dataSelection").show();
    });

    $("#statistics").on("click",function (){
        $("#statisticsSelection").show();
        $("#dataSelection").hide();
    });

    //Permet d'afficher les critères avancés pour les verbes
    $("#pos").change(function (){
        var selected = $("#pos > option:selected").val();
        if (selected === "Verbes"){
            $("#adjectiveCriteria").hide();
            $("#verbCriteria").show();
        } else if (selected === "Adjectifs") {
            $("#adjectiveCriteria").show();
            $("#verbCriteria").hide();
        } else {
            $("#adjectiveCriteria").hide();
            $("#verbCriteria").hide();
        }
    });

    //Permet d'afficher dans la zone de résultats les résultats de la requête faite par l'utilisateur
    $("#getResults").on("click", function (event) {
        event.preventDefault();
        //Critère généraux
        var corpus = $("#corpus > option:selected").val();
        var level = $("#level > option:selected").val();
        var pos = $("#pos > option:selected").val();
        var errStatus = $("#errStatus > option:selected").val();
        var segmStatus = $("#segmStatus > option:selected").val();
        var lemma = $("#lemma").val();

        //Sélection des données à envoyer si on a sélectionné un verbe
        if (pos === "Verbes"){
            var tense = $("#tense > option:selected").val();
            var person = $("#person > option:selected").val();
            var typeErr = $("#typeErr > option:selected").val();
            var base = $("#base > option:selected").val();
            var ending = $("#ending > option:selected").val();
            var data = 'corpus=' + corpus + '&level=' + level + '&pos=' + pos + '&errStatus=' + errStatus + '&segmStatus=' + segmStatus + '&lemma=' + lemma+ '&tense=' + tense+ '&person=' + person+ '&typeErr=' + typeErr+ '&base=' + base+ '&ending=' + ending;
        //Sélection des données si on a sélectionné un adjectif
        } else if (pos === "Adjectifs") {
            var genre = document.querySelector('input[name="genre"]:checked').value;
            var number = document.querySelector('input[name="number"]:checked').value;
            var errGenre = document.querySelector('input[name="errGenre"]:checked').value;
            var errNumber = document.querySelector('input[name="errNumber"]:checked').value;
            var baseAdj = $("#baseAdj").val();
            data = 'corpus=' + corpus + '&level=' + level + '&pos=' + pos + '&errStatus=' + errStatus + '&segmStatus=' + segmStatus + '&lemma=' + lemma+ '&genre=' + genre+ '&number=' + number+ '&errGenre=' + errGenre+ '&errNumber=' + errNumber+ '&baseAdj=' + baseAdj;
        //Si on n'a sélectionné ni un verbe ni un adjectif
        }else {
            data ='corpus=' + corpus + '&level=' + level + '&pos=' + pos + '&errStatus=' + errStatus + '&segmStatus=' + segmStatus + '&lemma=' + lemma
        }

        //Envoyer les données à la page d'index et récupérer le résultat
        $.ajax({
            url: 'index.php?action=showResults',
            method: 'POST',
            data: data,
            success: function (result) {
                //décoder le json
                var message = JSON.parse(result);

                //créer le tableau à injecter dans la page html

                $("#resultsTable").html("<tr id ='headerTab'><td>LIEN VERS LE SCAN</td><td>CORPUS</td><td>NIVEAU</td><td>ELEVE</td><td>LEMME</td><td>FORME NORMEE</td><td>FORME TRANSCRITE</td><td>PHONOLOGIE NORMEE</td><td>PHONOLOGIE TRANSCRITE</td><td>CATEGORIE</td><td>STATUT D'ERREUR</td><td>STATUT SEGMENTATION</td><td>GENRE</td><td>NOMBRE</td></tr>");
                for (var i = 0 ; i< message.length; i++){
                    //permettra d'afficher en couleur les différentes parties du mot produit par l'élève
                    //découpage en syllabes
                    var transSeg = message[i].SyllabTrans;
                    var cuttransSeg = transSeg.split("-");

                    //La base est le premier élément
                    var base = cuttransSeg[0];

                    //La désinence est le dernier élément (sauf s'il n'y a qu'une syllabe)
                    if (cuttransSeg.length > 1){
                        var ending = cuttransSeg[cuttransSeg.length - 1];
                    } else {
                        ending = "";
                    }

                    //S'il y a plus de deux syllabes on récupère es autres éléments
                    if (cuttransSeg.length > 2){
                        var index = cuttransSeg.length - 2;
                        var middle =cuttransSeg[1,index];
                    } else {
                        middle = "";
                    }

                    $("#resultsTable").append("<tr id = 'mot"+[i]+"'><td></td><td></td><td>" + message[i].Niv +"</td><td>" + message[i].IdProd +"</td><td>" + message[i].Lemme +"</td><td>" + message[i].SegNorm +"</td><td><span class='base' id = 'base"+[i]+"'>" + base+"</span><span class='middle' id = 'middle"+[i]+"'>" +middle+"</span><span class='ending' id = 'ending"+[i]+"'>" + ending+"</span></td><td>" + message[i].PhonNorm+"</td><td>" + message[i].PhonTrans+"</td><td>" + message[i].Categorie+"</td><td>" + message[i].StatutErreur+"</td><td>" + message[i].StatutSegm+"</td></tr>");

                    //Ajouter les classes correct ou false en fonction d'où se trouve l'erreur
                    if(message[i].ErrVerBase === "1"){
                        $("#base"+[i]).addClass("false");
                        $("#middle"+[i]).addClass("correct");
                        $("#ending"+[i]).addClass("correct");
                    } else if (message[i].ErrVerDes === "1"){
                        $("#base"+[i]).addClass("correct");
                        $("#middle"+[i]).addClass("correct");
                        $("#ending"+[i]).addClass("false");
                    } else if (message[i].ErrVerBaseEtDes === "1"){
                        $("#base"+[i]).addClass("false");
                        $("#middle"+[i]).addClass("correct");
                        $("#ending"+[i]).addClass("false");
                    } else if (message[i].ErrVerBase === "_" && message[i].ErrVerDes === "_" && message[i].ErrVerBaseEtDes === "_") {
                        $("#base"+[i]).addClass("none");
                        $("#middle"+[i]).addClass("none");
                        $("#ending"+[i]).addClass("none");
                    } else {
                        $("#base"+[i]).addClass("correct");
                        $("#middle"+[i]).addClass("correct");
                        $("#ending"+[i]).addClass("correct");
                    }

                    //Pour les noms et adjectifs ajouter le genre et le nombre
                    if (message[i].Categorie === "NOM" || message[i].Categorie === "NAM" || message[i].Categorie === "ADJ"){
                        $("#mot"+[i]).append("<td>" + message[i].Genre +"</td><td>" + message[i].Nombre +"</td>");
                    }

                }

                //Changer leur couleur en focntion des erreurs
                $(".correct").css("color", "#4CA86A");
                $(".false").css("color", "#4CA86A");

                //$("#resultsDiv").html(message);
            }
        });
    });

    //Envoyer le formulaire pour les stats
    //Permet d'afficher la partie permettant la sélection des verbes en -er ou non
    $("#tabStats").change(function (){
        var selected = $("#tabStats > option:selected").val();
        switch (selected){
            case "FailureAndSuccessTenses" :
                $("#tenseSelection").hide();
                $("#groupSelection").show();
                break;
            case "StandardizedBaseOrEnding" :
            case "StandardizedBaseEndingProportion" :
            case "VerbalFormsRepartitionBaseAndEndingPhono":
                $("#groupSelection").show();
                $("#tenseSelection").show();
                break;
            default :
                $("#groupSelection").hide();
                $("#tenseSelection").hide();
        }
    });

    //Permet d'afficher dans la zone de résultats les résultats de la requête faite par l'utilisateur
    $("#getStats").on("click", function (event) {
        //permet de ne pas envoyer le formulaire
        event.preventDefault();
        //Critères généraux
        var tabName = $("#tabStats > option:selected").val();
        switch (tabName){
            case "FailureAndSuccessTenses" :
                var verbGroup = document.querySelector('input[name="verbGroup"]:checked').value;
                var tense = "";
                break;
            case "StandardizedBaseOrEnding" :
            case "StandardizedBaseEndingProportion" :
            case "VerbalFormsRepartitionBaseAndEndingPhono":
                var verbGroup = document.querySelector('input[name="verbGroup"]:checked').value;
                tense = document.querySelector('input[name="tense"]:checked').value;
                break;
            default :
                verbGroup = "";
                tense = "";
        }

        //Données à envoyer vers le serveur avec ajax
        data = 'tabName=' + tabName + '&verbGroup=' + verbGroup + '&tense=' + tense;

        //Envoyer les données à la page d'index et récupérer le résultat
        $.ajax({
            url: 'index.php?action=showStats',
            method: 'POST',
            data: data,
            success: function (result) {
                //décoder le json
                var message = JSON.parse(result);
                switch (tabName) {
                    //Tableau : Nombre de motsdes productions
                    case "NbWordProd" :
                    //Tableau : Nombre de formes verbales analysées
                    case "NbVerbalForms" :
                    //Tableau : Répartition des formes verbales selon si leur base et/ou leur désinence sont normées
                    case "StandardizedBaseOrEnding" :
                    //Tableau : Proportion de bases et de désinences normées et non normées
                    case "StandardizedBaseEndingProportion" :
                    //Tableau : Répartition des formes verbales non normées selon si leur base et/ou leur désinence respectent ou non la phonologie
                    case "VerbalFormsRepartitionBaseAndEndingPhono":
                        $("#resultsTable").html("<tr id ='headerTab'><td></td><td>CP</td><td>CE1</td><td>CE2</td><td>CM1</td><td>CM2</td></tr>");
                        for (var key in message){
                            var value = message[key];
                            $("#resultsTable").append("<tr><td>" + key + "</td><td>" + value["CP"] + "</td><td>" + value["CE1"] + "</td><td>" + value["CE2"] + "</td><td>"+ value["CM1"]+ "</td><td>"+value["CM2"]+"</td></tr>");
                        }
                        break;
                    //Tableau : Répartition des POS (le même que les tiroirs verbaux)
                    case "POSRepartitionByLevel" :
                    //Tableau : Répartition des tiroirs verbaux
                    case "TenseRepartition" :
                        $("#resultsTable").html("<tr id ='headerTab'><td></td><td>CP</td><td>CE1</td><td>CE2</td><td>CM1</td><td>CM2</td><td>Total</td></tr>");
                        var infos = Object.keys(message["CP"]);
                        for (var i = 0 ; i< infos.length; i++) {
                            var info = infos[i];
                            $("#resultsTable").append("<tr><td>"+info+"</td><td>" + message["CP"][info] + "</td><td>" + message["CE1"][info] + "</td><td>" + message["CE2"][info] + "</td><td>" + message["CM1"][info] + "</td><td>" + message["CM2"][info] + "</td><td>" + message["Total"][info] + "</td></tr>");
                        }
                        break;
                    //Tableau : Répartition des échecs et réussites pour les tiroirs verbaux les plus employés
                    case "FailureAndSuccessTenses" :
                        $("#resultsTable").html("<tr id ='headerTab'><td></td><td></td><td>CP</td><td>CE1</td><td>CE2</td><td>CM1</td><td>CM2</td></tr>");
                        var infos = Object.keys(message["CP"]);
                        var subInfos = Object.keys(message["CP"]["Ensemble des Verbes"]);
                        for (var j = 0 ; j< infos.length; j++) {
                            for (var k = 0 ; k<subInfos.length; k++){
                                var info = infos[j];
                                var subInfo = subInfos[k];
                                $("#resultsTable").append("<tr><td>"+info+"</td><td>"+subInfo+"</td><td>" + message["CP"][info][subInfo] + "</td><td>" + message["CE1"][info][subInfo] + "</td><td>" + message["CE2"][info][subInfo] + "</td><td>" + message["CM1"][info][subInfo] + "</td><td>" + message["CM2"][info][subInfo] + "</td></tr>");
                            }
                        }
                        break;
                    default:
                        $("#resultsTable").html("<tr id ='headerTab'><td></td><td>CP</td><td>CE1</td><td>CE2</td><td>CM1</td><td>CM2</td></tr>");
                }

            }
        })
    });
});

