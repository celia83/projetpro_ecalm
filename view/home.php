<!DOCTYPE html>
<html>
    <head>
        <!-- Entête de la page-->
        <title>E-Calm</title>
        <meta charset="UTF-8"/> <!-- dit en quel encodage je suis-->
        <link rel="stylesheet" href = "../public/css/style.css"/> <!-- donne la feuille de style en css utilisée-->
        <script type="text/javascript" src="../public/js/jquery-3.4.1.js"></script> <!--appel de JQuery-->
        <script src="../public/js/script.js"></script> <!--Appel du script javascript-->
    </head>
    <body>
        <header>
            <img alt="logo_lidilem" id = "logo_lidilem" src="../public/assets/img/logo_LIDILEM_CMJN.jpg"/>
            <img alt="logo_ecalm" id = "logo_ecalm" src="../public/assets/img/Ecalm_logo_transparent.png"/>
            <section id="connexion">Connexion</section>
        </header>
        <section>
            <h1>Critères Généraux</h1>
            <form action ="../index.php?action=showGeneralResults" method="POST">
                <div>
                    <label for="corpus">Corpus</label><br />
                    <select  id="corpus" name="corpus">
                        <option value = "Tous">Tous</option>
                        <option value = "Scoledit">Scoledit</option>
                        <option value = "Ecriscol">Ecriscol</option>
                        <option value = "Resolco">Resolco</option>
                    </select>
                </div>
                <div>
                    <label for="level">Niveau</label><br />
                    <select  id="level" name="level">
                        <option value = "Tous">Tous</option>
                        <option value = "CP">CP</option>
                        <option value = "CE1">CE1</option>
                        <option value = "CE2">CE2</option>
                        <option value = "CM1">CM1</option>
                        <option value = "CM2">CM2</option>
                    </select>
                </div>
                <div>
                    <label for="pos">Catégorie grammaticale</label><br />
                    <select  id="pos" name="pos">
                        <option value = "Tous">Tous</option>
                        <option value = "Adjectifs">Adjectif</option>
                        <option value = "Adverbes">Adverbe</option>
                        <option value = "Verbes">Verbe</option>
                        <option value = "Noms">Nom</option>
                        <option value = "Noms propres">Nom Propre</option>
                        <option value = "Déterminants">Déterminant</option>
                        <option value = "Pronoms">Pronom</option>
                        <option value = "Prépositions">Préposition</option>
                        <option value = "Conjonctions de coordination">Conjonction de coordination</option>
                        <option value = "Conjonctions de suborditation">Conjonction de suborditation</option>
                        <option value = "Abrévations">Abrévations</option>
                        <option value = "Interjections">Interjections</option>
                        <option value = "Chiffres">Chiffres</option>
                    </select>
                </div>
                <div>
                    <label for="errStatus">Statut d'erreur</label><br />
                    <select  id="errStatus" name="errStatus">
                        <option value = "Tous">Tous</option>
                        <option value = "Norm">Normé</option>
                        <option value = "Phono">Phono</option>
                        <option value = "ApproxGraphique">ApproxGraphique </option>
                        <option value = "ApproxPhono">ApproxPhono </option>
                        <option value = "ApproxArchiPhono">ApproxArchiPhono</option>
                        <option value = "Non norm">Non normé</option>
                        <option value = "Non pertinent">Non pertinent</option>
                    </select>
                </div>
                <div>
                    <label for="segmStatus">Statut de segmentation</label><br />
                    <select  id="segmStatus" name="segmStatus">
                        <option value = "Tous">Tous</option>
                        <option value = "Norm">Normé</option>
                        <option value = "HyperSeg">HyperSeg</option>
                        <option value = "HypoSeg">HypoSeg</option>
                        <option value = "HypoHyperSeg">HypoHyperSeg</option>
                        <option value = "Non pertinent">Non pertinent</option>
                        <option value = "Omis">Omis</option>
                        <option value = "Inséré">Inséré</option>
                    </select>
                </div>
                <div>
                    <label for="lemma">Lemme</label><br />
                    <input type="text" id="lemma" name="lemma" />
                </div>
                <div>
                    <input id="getResults" value ="Résultats" type="submit" />
                </div>
            </form>
        </section>
        <section>
            <h1>Résultats</h1>
            <div id = "resultsDiv">

            </div>
        </section>
    </body>
</html>
