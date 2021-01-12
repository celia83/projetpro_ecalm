<?php
#include "NbWordProd.php";
#include "TenseRepartition.php";
#include "POSRepartitionByLevel.php";
include "FailureAndSuccessTenses.php";


#$nbWords = new NbWordProd();
#var_dump($nbWords->createTabNbWordsProd());

#$tabPOS = new TenseRepartition();
#var_dump($tabPOS->createTabTenseRepartition());


#$tabPOS = new POSRepartitonByLevel();
#var_dump($tabPOS->createTabPOSRepartitionByLevel());

$tabVerb = new FailureAndSuccessTenses();
var_dump($tabVerb->createTabFailureSuccess("nonEr"));

