<?php
include "DownloadResults.php";
#include "DownloadResultNbWordProd.php";
#include "DownloadResultPOSRepartitionByLevel.php";
#include "DownloadResultTenseRepartition.php";
#include "DownloadResultNbVerbalForms.php";
#include "DownloadResultFailureAndSuccessTenses.php";
#include "DownloadResultStandardizedBaseOrEnding.php";
#include "DownloadResultStandardizedBaseEndingProportion.php";
#include "DownloadResultVerbalFormsRepartitionBaseAndEndingPhono.php";

$table = array('0'=>array(' ','CP','CE1','CE2'),
              '1'=>array('nombre','0','0','1'),
			  '2'=>array('longueur','0','0','2') 
             );
             
             
$resultat = new DownloadResults();
$resultat->downloadTables($table);

#$resultat = new DownloadResultNbWordProd();
#var_dump($resultat->getResultsformNbWordProd());

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
