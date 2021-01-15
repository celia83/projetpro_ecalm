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

        <!--Partie pour la sélection des critère-->
        <section id = "criteriaSelection">
            <form action ="../index.php?action=showResults" method="POST">
                <!--Afficher les critères généraux -->
                <section id = "generalCriteria">
                    <h2>Critères Généraux</h2>
                    <div>
                        <label for="corpus">Corpus : </label>
                        <select  id="corpus" name="corpus">
                            <option value = "Tous">Tous</option>
                            <option value = "Scoledit">Scoledit</option>
                            <option value = "Ecriscol">Ecriscol</option>
                            <option value = "Resolco">Resolco</option>
                        </select>
                    </div>
                    <div>
                        <label for="level">Niveau : </label>
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
                        <label for="pos">Catégorie grammaticale : </label>
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
                            <option value = "Conjonctions">Conjonction de coordination et de subordination</option>
                            <option value = "Abréviations">Abréviations</option>
                            <option value = "Interjections">Interjections</option>
                            <option value = "Chiffres">Chiffres</option>
                        </select>
                    </div>
                    <div>
                        <label for="errStatus">Statut d'erreur : </label>
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
                        <label for="segmStatus">Statut de segmentation : </label>
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
                        <label for="lemma">Lemme : </label>
                        <input type="text" id="lemma" name="lemma" />
                    </div>
                </section>

                <!--Afficher les critères spécifiques aux verbes -->
                <section id = "verbCriteria" hidden>
                    <h2>Critères Avancés</h2>
                    <div>
                        <label for="tense">Tiroir verbal : </label>
                        <select  id="tense" name="tense">
                            <option value = "Tous">Tous</option>
                            <option value = "Conditionnel">Conditionnel</option>
                            <option value = "Futur">Futur</option>
                            <option value = "Impératif">Impératif</option>
                            <option value = "Imparfait">Imparfait</option>
                            <option value = "Infinitif">Infinitif</option>
                            <option value = "Participe présent">Participe présent</option>
                            <option value = "Présent">Présent</option>
                            <option value = "Passé simple">Passé simple</option>
                            <option value = "Subjonctif imparfait">Subjonctif imparfait</option>
                            <option value = "Subjonctif présent">Subjonctif présent</option>
                        </select>
                    </div>
                    <div>
                        <label for="person">Personne : </label>
                        <select  id="person" name="person">
                            <option value = "Tous">Tous</option>
                            <option value = "1S">1S</option>
                            <option value = "2S">2S</option>
                            <option value = "3S">3S</option>
                            <option value = "1P">1P</option>
                            <option value = "2P">2P</option>
                            <option value = "3P">3P</option>
                        </select>
                    </div>

                    <div>
                        <label for="typeErr">Type d'erreur : </label>
                        <select  id="typeErr" name="typeErr">
                            <option value = "Aucune">Aucune</option>
                            <option value = "Erreur Base">Erreur Base</option>
                            <option value = "Erreur Désinence">Erreur Désinence</option>
                            <option value = "Erreur Base et Désinence">Erreur Base et Désinence</option>
                        </select>
                    </div>

                    <div>
                        <label for="base">Base</label><br/>
                        <input type="text" id="base" name="base" />
                    </div>
                    <div>
                        <label for="ending">Désinence</label><br/>
                        <input type="text" id="ending" name="ending" />
                    </div>

                </section>

                <!--Afficher les critères spécifiques aux adjectifs -->
                <section id = "adjectiveCriteria" hidden >
                    <h2>Critères Avancés</h2>
                    <div>
                        <label for="genre">Genre : </label>
                        <input type="radio" id = "Masculin" class="genre" name="genre" value = "Masculin"/><label for="Masculin">Masculin</label>
                        <input type="radio" id = "Féminin" class="genre" name="genre" value = "Féminin"/><label for="Féminin">Féminin</label>
                        <input type="radio" id = "Les deux" class="genre" name="genre" value = "Les deux"/><label for="Les deux">Les deux</label>
                    </div>

                    <div>
                        <label for="number">Nombre : </label>
                        <input type="radio" id = "Singulier" class="number" name="number" value = "Singulier"/><label for="Singulier">Singulier</label>
                        <input type="radio" id = "Pluriel" class="number" name="number" value = "Pluriel"/><label for="Pluriel">Pluriel</label>
                        <input type="radio" id = "Les deux" class="number" name="number" value = "Les deux"/><label for="Les deux">Les deux</label>
                    </div>

                    <div>
                        <label for="errGenre">Erreur de genre : </label>
                        <input type="radio" id = "Avec" class="errGenre" name="errGenre" value = "Avec"/><label for="Avec">Avec</label>
                        <input type="radio" id = "Sans" class="errGenre" name="errGenre" value = "Sans"/><label for="Sans">Sans</label>
                        <input type="radio" id = "Tous" class="errGenre" name="errGenre" value = "Tous"/><label for="Tous">Tous</label>
                    </div>

                    <div>
                        <label for="errNumber">Erreur de nombre : </label>
                        <input type="radio" id = "Avec" class="errNumber" name="errNumber" value = "Avec"/><label for="Avec">Avec</label>
                        <input type="radio" id = "Sans" class="errNumber" name="errNumber" value = "Sans"/><label for="Sans">Sans</label>
                        <input type="radio" id = "Tous" class="errNumber" name="errNumber" value = "Tous"/><label for="Tous">Tous</label>
                    </div>

                    <div>
                        <label for="baseAdj">Base</label><br/>
                        <input type="text" id="baseAdj" name="baseAdj" />
                    </div>

                </section>

                <div>
                    <input id="getResults" value ="Résultats" type="submit" />
                </div>
            </form>
        </section>

        <!--Partie pour l'affichage des résultats-->
        <section>
            <h2>Résultats</h2>
            <div id = "resultsDiv">
                <table id = "resultsTable">

                </table>
            </div>
        </section>
    </body>
</html>
