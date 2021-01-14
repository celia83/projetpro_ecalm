<?php
#include "NbWordProd.php";
#include "TenseRepartition.php";
#include "POSRepartitionByLevel.php";
#include "FailureAndSuccessTenses.php";
#include "StandardizedBaseOrEnding.php";
#include "StandardizedBaseEndingProportion.php";
#include "NbFormeVerbales.php";
#include "AllVerbs.php";
include "RepartionFormesVerbales.php";

#$nbWords = new NbWordProd();
#var_dump($nbWords->createTabNbWordsProd());

#$tabPOS = new TenseRepartition();
#var_dump($tabPOS->createTabTenseRepartition());

#$tabPOS = new POSRepartitonByLevel();
#var_dump($tabPOS->createTabPOSRepartitionByLevel());

#$tabVerb = new FailureAndSuccessTenses();
#var_dump($tabVerb->createTabFailureSuccess("nonEr"));

#$tab = new StandardizedBaseOrEnding();
#var_dump($tab->createTabStandardizedBaseOrEnding("tous", "Imparfait"));

#$tab = new StandardizedBaseEndingProportion();
#var_dump($tab->createTabStandardizedBaseEndingProportion("tous", "Imparfait"));

#$nbverbales = new NbFormeVerbales();
#var_dump($nbverbales->createTabNbFormeVerbales());

#$tabVerbs = new AllVerbs();
#var_dump($tabVerbs->createTabAllVerbs());

$repartionFormesVerbales = new RepartionFormesVerbales();
var_dump($repartionFormesVerbales->createTabRepartionFormesVerbales());


