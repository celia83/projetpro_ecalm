<?php
#include "NbWordProd.php";
include "TenseRepartition.php";


#$nbWords = new NbWordProd();
#var_dump($nbWords->createTabNbWordsProd());

$tabVerb = new TenseRepartition();
var_dump($tabVerb->createTabTenseRepartition());

