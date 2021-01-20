<?php

include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/Statistics/POSRepartitionByLevel.php";

class DownloadResultPOSRepartitionByLevel{
     
    public function getResultsformPOSRepartitionByLevel(){
		/**
		 * Cette fonction permet de télécharger les résultats du tableau de POSRepartitionByLevel
		 * @return un nouveau fichier de tsv
		 */
			
        #exporter directement un fichier de tsv 
		header ( 'Content-Type: text/tab-separated-values' );
		header ( 'Content-Disposition: attachment;filename="Résultats.tsv"' );
		header ( 'Cache-Control: max-age=0' );
		
		#ouvrir/créer un fichier sur le navigateur du web
		$fp = fopen ( 'php://output', 'w' );

		#obtenir le contenu du tableau 
		$nbWords = new POSRepartitionByLevel();
		$data =$nbWords->createTabPOSRepartitionByLevel();
		
		#éviter les problèmes d'encodages
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        
        #parcourir le contenu du tableau et les écrire au fichier       
        foreach($data as $k=>$v) { 
			$title =array($k); 
			fputcsv($fp,$title,"\n"); 
			foreach($v as $c=>$d) {
				$row = array ($c, $d); 
				fputcsv($fp,$row,"\t "); 
				
			}
		}
		
        #fermer ce fichier
        fclose($fp);
		
    }    
}
