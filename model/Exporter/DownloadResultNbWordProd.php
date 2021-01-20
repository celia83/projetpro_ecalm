<?php

include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/Statistics/NbWordProd.php";

class DownloadResultNbWordProd{
     
    public function getResultsformNbWordProd(){
		/**
		 * Cette fonction permet de télécharger les résultats du tableau de NbWordProd
		 * @return un nouveau fichier de tsv
		 */
			
        #exporter directement un fichier de tsv 
		header ( 'Content-Type: text/tab-separated-values' );
		header ( 'Content-Disposition: attachment;filename="Résultats.tsv"' );
		header ( 'Cache-Control: max-age=0' );
		
		#ouvrir/créer un fichier sur le navigateur du web
		$fp = fopen ( 'php://output', 'w' );

		#obtenir le contenu du tableau 
		$nbWords = new NbWordProd();
		$data =$nbWords->createTabNbWordsProd();
		
		#définir la première colonne
		$title = [
			"CP",
			"CE1",
			"CE2",
			"CM1",
			"CM2",
			"CP-CM2"
		];
		
		#définir la première ligne
		$clecolo = [
			'',
			"Nombre de Mots (hors ponctuation)",
			"Longueur moyenne de production",
			"Nombre de mots max.",
			"Nombre de mots min." 
		];
		
		#écrir la première ligne dans ce fichier
		array_unshift($data,$title);
		
		#éviter les problèmes d'encodages
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        
        #parcourir le contenu du tableau et les écrire au fichier
		foreach ($data as $fields) {
			array_unshift($fields,array_shift($clecolo));
			fputcsv($fp, $fields,"\t");
        }
        
        #fermer ce fichier
        fclose($fp);
		
    }    
}
