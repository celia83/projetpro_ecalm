<?php

#Chargement des classes
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/Criterion.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionVerb.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionAdjective.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/Statistics/NbWordProd.php');

class HomeController {
    /**
     * Cette fonction permet d'afficher la page d'accueil
     */
    function home(){
        require('view/home.php');
    }

    /**
     * Critère généraux : Permet de retourner les résultats de la requête faite par l'utilisateur au format JSON
     * @param $corpus
     * @param $level
     * @param $pos
     * @param $errStatus
     * @param $segmStatus
     * @param $lemma
     */
    function showResultsCriteria($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){
        $criterion = new Criterion($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
        $results = $criterion->getResults();
        //require('view/home.php');
        //$message = ['erreur' => "Votre mot de passe est trop long."];

        echo json_encode($results);
        //var_dump($results);
    }
    /**
     * Critères verbes : Permet de retourner les résultats de la requête faite par l'utilisateur au format JSON pour les verbes
     * @param $corpus
     * @param $level
     * @param $pos
     * @param $errStatus
     * @param $segmStatus
     * @param $lemma
     * @param $tense
     * @param $person
     * @param $typeErr
     * @param $desinence
     * @param $base
     */
    function showResultsCriteriaVerbs($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $tense, $person, $typeErr, $base, $ending){
        $criterion = new CriterionVerb($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $tense, $person, $typeErr, $base, $ending);
        $results = $criterion->getResultsVerb();
        echo json_encode($results);
    }

    /**
     * Critères adjectifs : Permet de retourner les résultats de la requête faite par l'utilisateur au format JSON pour les adjectifs
     * @param $corpus
     * @param $level
     * @param $pos
     * @param $errStatus
     * @param $segmStatus
     * @param $lemma
     * @param $genre
     * @param $numbre
     * @param $errGenre
     * @param $errNumber
     * @param $base
     */
    function showResultsCriteriaAdjectives($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $genre, $numbre, $errGenre, $errNumber, $base){
        $criterion = new CriterionAdjective($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $genre, $numbre, $errGenre, $errNumber, $base);
        $results = $criterion->getResultsAdjective();
        echo json_encode($results);
    }

    function showStatsTab($tabName, $verbGroup, $tense){
        # Tableau supprimé: Nombre de formes verbales, de bases et de désinences analysées
        switch ($tabName) {
            #Tableau : Nombre de motsdes productions
            case "NbWordProd" :
                $nbWordProd = new NbWordProd();
                $tab = $nbWordProd->createTabNbWordsProd();
                echo json_encode($tab);
                break;
            #Tableau : Répartition des POS
            case "POSRepartitionByLevel" :
                $posRepartitionByLevel = new POSRepartitionByLevel();
                $tab = $posRepartitionByLevel->createTabPOSRepartitionByLevel();
                echo json_encode($tab);
                break;
            #Tableau : Répartition des tiroirs verbaux
            case "TenseRepartition" :
                $tenseRepartition = new TenseRepartition();
                $tab = $tenseRepartition->createTabTenseRepartition();
                echo json_encode($tab);
                break;
            #Tableau : Nombre de formes verbales analysées
            case "NbVerbalForms" :
                $nbVerbalForms = new NbVerbalForms();
                $tab = $nbVerbalForms->createTabNbVerbalForms();
                echo json_encode($tab);
                break;
            #Tableau : Répartition des échecs et réussites pour les tiroirs verbaux les plus employés
            case "FailureAndSuccessTenses" :
                $failureAndSuccessTenses = new FailureAndSuccessTenses();
                $tab =$failureAndSuccessTenses->createTabFailureSuccess($verbGroup);
                echo json_encode($tab);
                break;
            #Tableau : Répartition des formes verbales selon si leur base et/ou leur désinence sont normées
            case "StandardizedBaseOrEnding" :
                $standardizedBaseOrEnding = new StandardizedBaseOrEnding();
                $tab =$standardizedBaseOrEnding->createTabStandardizedBaseOrEnding($verbGroup, $tense);
                echo json_encode($tab);
                break;
            #Tableau : Proportion de bases et de désinences normées et non normées
            case "StandardizedBaseEndingProportion" :
                $standardizedBaseEndingProportion = new StandardizedBaseEndingProportion();
                $tab =$standardizedBaseEndingProportion ->createTabStandardizedBaseEndingProportion($verbGroup, $tense);
                echo json_encode($tab);
                break;
            default:
                echo "Le tableau n'a pas pu être généré";
        }

    }
}
