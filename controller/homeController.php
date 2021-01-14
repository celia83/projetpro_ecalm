<?php

#Chargement des classes
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/Criterion.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionVerb.php');
require_once('D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/SearchByCriteria/CriterionAdjective.php');

function showResultsCriteria($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){


    $criterion = new Criterion($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
    $results = $criterion->getResults();
    var_dump($results);
    require('view/home.php');

}