<?php
#include "NbWordProd.php";
include "TenseRepartition.php";


#$nbWords = new NbWordProd();
#var_dump($nbWords->createTabNbWordsProd());

$tabPOS = new TenseRepartition();
var_dump($tabPOS->createTabTenseRepartition());

include "POSRepartitionByLevel.php";
$tabPOS = new POSRepartitonByLevel();
var_dump($tabPOS->createTabPOSRepartitionByLevel());

