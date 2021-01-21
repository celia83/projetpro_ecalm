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
                if(pos === "Adjectifs" || pos === "Noms"){
                    $("#resultsTable").html("<tr id ='headerTab'><td>SCAN</td><td>CORPUS</td><td>NIVEAU</td><td>ELEVE</td><td>LEMME</td><td>FORME<br/>NORMEE</td><td>FORME<br/>TRANSCRITE</td><td>PHONOLOGIE<br/>NORMEE</td><td>PHONOLOGIE<br/>TRANSCRITE</td><td>CATEGORIE</td><td>STATUT<br/>D'ERREUR</td><td>STATUT<br/>SEGMENTATION</td><td>GENRE</td><td>NOMBRE</td></tr>");
                } else if (pos === "Verbes"){
                    $("#resultsTable").html("<tr id ='headerTab'><td>SCAN</td><td>CORPUS</td><td>NIVEAU</td><td>ELEVE</td><td>LEMME</td><td>FORME<br/>NORMEE</td><td>FORME<br/>TRANSCRITE</td><td>PHONOLOGIE<br/>NORMEE</td><td>PHONOLOGIE<br/>TRANSCRITE</td><td>CATEGORIE</td><td>STATUT<br/>D'ERREUR</td><td>STATUT<br/>SEGMENTATION</td><td>TIROIR<br/>VERBAL</td><td>PERSONNE</td></tr>");
                } else {
                    $("#resultsTable").html("<tr id ='headerTab'><td>SCAN</td><td>CORPUS</td><td>NIVEAU</td><td>ELEVE</td><td>LEMME</td><td>FORME<br/>NORMEE</td><td>FORME<br/>TRANSCRITE</td><td>PHONOLOGIE<br/>NORMEE</td><td>PHONOLOGIE<br/>TRANSCRITE</td><td>CATEGORIE</td><td>STATUT<br/>D'ERREUR</td><td>STATUT<br/>SEGMENTATION</td></tr>");
                }

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

                    //S'il y a plus de deux syllabes on récupère les autres éléments
                    if (cuttransSeg.length > 2){
                        var index = cuttransSeg.length - 2;
                        var middle =cuttransSeg[1,index];
                    } else {
                        middle = "";
                    }

                    //Traitement pour connaitre le corpus
                    var regexScoledit = new RegExp("[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-S[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+");
                    var regexEcriscol = new RegExp("[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-E[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+");
                    var regexResolco = new RegExp("[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-R[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+");
                    var corpus ="";
                    if (regexScoledit.test(message[i].IdTok)){
                        corpus = "Scoledit";
                    } else if (regexEcriscol.test(message[i].IdTok)){
                        corpus = "Ecriscol";
                    } else if (regexResolco.test(message[i].IdTok)){
                        corpus = "Resolco";
                    }

                    //Normalisation des catégories
                    var posMessage = message[i].Categorie;
                    if (posMessage === "ADV"){
                        pos = "Adverbe";
                    } else if (posMessage === "ADJ"){
                        pos = "Adjectif";
                    } else if (posMessage.search("VER") === 0){
                        pos = "Verbe";
                    } else if (posMessage === "NOM"){
                        pos = "Nom";
                    } else if (posMessage === "NAM"){
                        pos = "Nom propre";
                    } else if (posMessage.search("DET") === 0) {
                        pos = "Déterminant";
                    } else if (posMessage.search("PRO") === 0){
                        pos = "Pronom";
                    } else if (posMessage.search("PRP") === 0){
                        pos = "Préposition";
                    } else if (posMessage === "KON"){
                        pos = "Conjonction";
                    } else if (posMessage === "ABR"){
                        pos = "Abréviation";
                    } else if (posMessage === "NUM"){
                        pos = "Chiffres";
                    } else if (posMessage === "INT"){
                        pos = "Interjections";
                    } else {
                        pos = "Aucune";
                    }

                    //Remplissage des lignes du tableau
                    if(pos === "Adjectif" || pos === "Nom"){
                        $("#resultsTable").append("<tr id = 'mot"+[i]+"'><td></td><td>" + corpus +"</td><td>" + message[i].Niv +"</td><td>" + message[i].IdProd +"</td><td>" + message[i].Lemme +"</td><td>" + message[i].SegNorm +"</td><td><span class='base' id = 'base"+[i]+"'>" + base+"</span><span class='middle' id = 'middle"+[i]+"'>" +middle+"</span><span class='ending' id = 'ending"+[i]+"'>" + ending+"</span></td><td>" + message[i].PhonNorm+"</td><td>" + message[i].PhonTrans+"</td><td>" + pos+"</td><td>" + message[i].StatutErreur+"</td><td>" + message[i].StatutSegm+"</td><td>" + message[i].Genre +"</td><td>" + message[i].Nombre +"</td></tr>");
                    } else if (pos === "Verbe") {
                        //Trouver le tiroir verbal
                        if (posMessage.search("cond") === 4){
                            var tense = "Conditionnel";
                        } else if (posMessage.search("futu")=== 4){
                            tense = "Futur";
                        } else if (posMessage.search("impe") === 4){
                            tense = "Impératif";
                        } else if (posMessage.search("impf") === 4){
                            tense = "Imparfait";
                        } else if (posMessage.search("infi") === 4) {
                            tense = "Infinitif";
                        } else if (posMessage.search("ppre") === 4){
                            tense = "Participe présent";
                        } else if (posMessage.search("pres") ===4){
                            tense = "Présent";
                        } else if (posMessage.search("simp") === 4){
                            tense= "Passé simple";
                        } else if (posMessage.search("subi")=== 4){
                            tense = "Subjonctif imparfait";
                        } else if (posMessage.search("subp")=== 4){
                            tense = "Subjonctif présent";
                        }

                        $("#resultsTable").append("<tr id = 'mot"+[i]+"'><td></td><td>" + corpus +"</td><td>" + message[i].Niv +"</td><td>" + message[i].IdProd +"</td><td>" + message[i].Lemme +"</td><td>" + message[i].SegNorm +"</td><td><span class='base' id = 'base"+[i]+"'>" + base+"</span><span class='middle' id = 'middle"+[i]+"'>" +middle+"</span><span class='ending' id = 'ending"+[i]+"'>" + ending+"</span></td><td>" + message[i].PhonNorm+"</td><td>" + message[i].PhonTrans+"</td><td>" + pos+"</td><td>" + message[i].StatutErreur+"</td><td>" + message[i].StatutSegm+"</td><td>" + tense +"</td><td>" + message[i].VerPers +"</td></tr>");
                    } else {
                        $("#resultsTable").append("<tr id = 'mot"+[i]+"'><td></td><td>" + corpus +"</td><td>" + message[i].Niv +"</td><td>" + message[i].IdProd +"</td><td>" + message[i].Lemme +"</td><td>" + message[i].SegNorm +"</td><td><span class='base' id = 'base"+[i]+"'>" + base+"</span><span class='middle' id = 'middle"+[i]+"'>" +middle+"</span><span class='ending' id = 'ending"+[i]+"'>" + ending+"</span></td><td>" + message[i].PhonNorm+"</td><td>" + message[i].PhonTrans+"</td><td>" + pos+"</td><td>" + message[i].StatutErreur+"</td><td>" + message[i].StatutSegm+"</td></tr>");
                    }

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
                }

                //Changer leur couleur en fonction des erreurs
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

    //Statistiques : Permet d'afficher dans la zone de résultats les résultats de la requête faite par l'utilisateur
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
                            $("#resultsTable").append("<tr id = 'ligne"+j+"'><td rowspan='4'>"+infos[j]+"</td></tr>");
                            for (var k = 0 ; k<subInfos.length; k++){
                                var info = infos[j];
                                var subInfo = subInfos[k];
                                //$("#resultsTable").append("<tr><td>"+info+"</td><td>"+subInfo+"</td><td>" + message["CP"][info][subInfo] + "</td><td>" + message["CE1"][info][subInfo] + "</td><td>" + message["CE2"][info][subInfo] + "</td><td>" + message["CM1"][info][subInfo] + "</td><td>" + message["CM2"][info][subInfo] + "</td></tr>");
                                if(k === 0){
                                    $("#ligne"+j).append("<td>"+subInfo+"</td><td>" + message["CP"][info][subInfo] + "</td><td>" + message["CE1"][info][subInfo] + "</td><td>" + message["CE2"][info][subInfo] + "</td><td>" + message["CM1"][info][subInfo] + "</td><td>" + message["CM2"][info][subInfo] + "</td>");
                                } else {
                                    $("#resultsTable").append("<tr><td>"+subInfo+"</td><td>" + message["CP"][info][subInfo] + "</td><td>" + message["CE1"][info][subInfo] + "</td><td>" + message["CE2"][info][subInfo] + "</td><td>" + message["CM1"][info][subInfo] + "</td><td>" + message["CM2"][info][subInfo] + "</td></tr>");
                                }

                            }
                        }
                        break;
                    default:
                        $("#resultsTable").html("<tr id ='headerTab'><td></td><td>CP</td><td>CE1</td><td>CE2</td><td>CM1</td><td>CM2</td></tr>");
                }

            }
        })
    });

    //Récupère le tableau contenu dans la balise html <table> et l'envoi au routeur sous forme d'array avec une ligne du tableau html par case de l'array
    $("#downloadTable").on("click", function (){
        //récupérer le contenu de la balise <table>
        var tableHTML = document.getElementById("resultsTable").rows;
        var table = [];
        for (var i = 0; i < tableHTML.length; i++){
            var line = [];
            for (var j = 0; j < tableHTML[i].cells.length; j++){
                line.push(tableHTML[i].cells[j].innerHTML);
            }
            table.push(line);
        }

        //console.log(table);
        //console.log(table);
        //console.log(table[0].cells[1].innerHTML);

        $.ajax({
            url: 'index.php?action=downloadResults',
            method: 'POST',
            data: {dataTable:JSON.stringify(table)},
            success: function (result) {
                //console.log(result);
            }
        });
    });

    //Récupère le tableau contenu dans la balise html <table> et l'envoi au routeur sous forme d'array avec une ligne du tableau html par case de l'array
    $("body").on("click","#downloadExemplier", function (){
        $("#downloadExemplierSection").show();
        //récupérer le contenu de la balise <table>
        var tableHTML = document.getElementById("resultsTable").rows;
        var tableWords = [];
        for (var i = 1; i < tableHTML.length; i++){
            var lemma = tableHTML[i].cells[4].innerHTML;
            if (tableWords.includes(lemma) === false){
                tableWords.push(lemma);
            }
        }
        for (var j = 0; j < tableWords.length; j++){

            $("select#word").append("<option id='"+tableWords[j]+"'>"+tableWords[j]+"</option>");
        }
    });

    $("body").on("click",".fa-times", function (){
        $("#downloadExemplierSection").hide();
    });
});

