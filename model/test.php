<?php
include"Criterion.php";
include"CriterionAdjective.php";

$criterion = new Criterion("Scoledit", "CM2", "nom","none","base","manger");
/*var_dump($criterion->getResults());*/
$criterionAdj = new CriterionAdjective("Scoledit", "CM2", "nom","none","base","manger","femme", "pluriel", "accord", "pass", "non");
/*var_dump($criterionAdj->getResultsAdjective());*/