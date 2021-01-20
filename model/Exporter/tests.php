<?php

include "DownloadResultNbWordProd.php";
#include "DownloadResultPOSRepartitionByLevel.php";
#include "DownloadResultTenseRepartition.php";
#include "DownloadResultNbVerbalForms.php";
#include "DownloadResultFailureAndSuccessTenses.php";
#include "DownloadResultStandardizedBaseOrEnding.php";
#include "DownloadResultStandardizedBaseEndingProportion.php";
#include "DownloadResultVerbalFormsRepartitionBaseAndEndingPhono.php";



$resultat = new DownloadResultNbWordProd();
var_dump($resultat->getResultsformNbWordProd());

#$POSRepartitionByLevel= new DownloadResultPOSRepartitionByLevel();
#var_dump($POSRepartitionByLevel->getResultsformPOSRepartitionByLevel());

#$TenseRepartition= new DownloadResultTenseRepartition();
#var_dump($TenseRepartition->getResultsformTenseRepartition());

#$NbVerbalForms= new DownloadResultNbVerbalForms();
#var_dump($NbVerbalForms->getResultsformNbVerbalForms());

#$FailureAndSuccessTenses= new DownloadResultFailureAndSuccessTenses();
#var_dump($FailureAndSuccessTenses->getResultsformFailureAndSuccessTenses());

#$StandardizedBaseOrEnding= new DownloadResultStandardizedBaseOrEnding();
#var_dump($StandardizedBaseOrEnding->getResultsformStandardizedBaseOrEnding());

#$StandardizedBaseEndingProportion= new DownloadResultStandardizedBaseEndingProportion();
#var_dump($StandardizedBaseEndingProportion->getResultsformStandardizedBaseEndingProportion());

#$VerbalFormsRepartitionBaseAndEndingPhono= new DownloadResultVerbalFormsRepartitionBaseAndEndingPhono();
#var_dump($VerbalFormsRepartitionBaseAndEndingPhono->getResultsformVerbalFormsRepartitionBaseAndEndingPhono());
