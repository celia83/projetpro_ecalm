<?php
include"Criterion.php";
include"CriterionAdjective.php";
include"CriterionVerb.php";

#$criterion = new Criterion("Scoledit", "CM2", "Nom","Norm%","Norm%","");
#var_dump($criterion->getResults());

#$criterionAdj = new CriterionAdjective("Scoledit", "CM2", "Adjectif","Norm%","Norm%","","Masculin", "Singulier", "Non", "Non", "");
#var_dump($criterionAdj->getResultsAdjective());

$criterionVer = new CriterionVerb("Scoledit", "CM2", "Adjectif","Norm%","Norm%","", "Imparfait","S3", "Aucune","", "pouv");
var_dump($criterionVer->getResultsVerb());