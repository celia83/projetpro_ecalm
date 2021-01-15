<?php

#Chargement des classes
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/Criterion.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionVerb.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionAdjective.php');

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

    function showResultsCriteriaAdjectives($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $genre, $numbre, $errGenre, $errNumber, $base){
        $criterion = new CriterionAdjective($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $genre, $numbre, $errGenre, $errNumber, $base);
        $results = $criterion->getResultsAdjective();
        echo json_encode($results);
    }
}
