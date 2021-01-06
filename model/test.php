<?php
include"Criterion.php";
include"CriterionAdjective.php";

$criterion = new Criterion("Scoledit", "CM2", "Nom","Norm%","Norm%","");
$criterion->getResults();
$criterionAdj = new CriterionAdjective("Scoledit", "CM2", "NOM","none","base","manger","femme", "pluriel", "accord", "pass", "non");
/*var_dump($criterionAdj->getResultsAdjective());*/