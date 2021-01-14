<?php

#Chargement des classes
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/Criterion.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionVerb.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionAdjective.php');

class HomeController {
    function showResultsCriteria($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){
        $criterion = new Criterion($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
        $results = $criterion->getResults();
        //require('view/home.php');
        //$message = ['erreur' => "Votre mot de passe est trop long."];

        echo json_encode($results);
        //var_dump($results);
    }

    function home(){
        require('view/home.php');
    }
}
