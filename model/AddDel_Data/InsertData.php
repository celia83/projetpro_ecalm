<?php

#connecter à la base de données
include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/DataBase.php";

class InsertData
{
	/**
     * Cette fonction inséré les données du fichier de csv à la base de données
     */
     
	#la fonction de traiter le fichier
	public function input_csv($handle)
		{   
			$out = array ();   
			$n = 0;   
			while ($data = fgetcsv($handle, 100000))   
			{   
				$num = count($data);   
				for ($i = 0; $i < $num; $i++)   
				{   
					$out[$n][$i] = $data[$i];   
				}   
				$n++;   
			}   
			return $out;   
		}  

	#la fonction d'inserer
	public function addCSV($file_path){

			
			if ( file_exists ( $file_path )){

			$handle = fopen($file_path, 'r');   			   
			}
			
			#traiter le fichier de csv

			$result = self::input_csv($handle);
			$len_result = count($result);  

			#voir si le fichier est vide
			if($len_result==0)   
			{   
				echo 'Rien dans ce fichier !';   
				exit;   
			} 
			  
			#un boucle pour obtenir les valeurs
			$data_values="";
			for($i = 1; $i < $len_result; $i++){

				#split chaque ligne par ';'
				$listre =  explode (';',implode($result[$i])); 
				
				#trouver les valeurs des colonnes 
				$IdTok = ($listre[0]);   
				$IdProd = ($listre[1]);   
				$Niv = ($listre[2]);
				$SegNorm = ($listre[3]);
				$SegTrans= ($listre[4]);
				$PhonNorm = ($listre[5]);
				$PhonTrans = ($listre[6]);
				$SyllabNorm	= ($listre[7]);
				$SyllabTrans = ($listre[8]);
				$Categorie = ($listre[9]);	
				$Lemme = ($listre[10]);
				$StatuErreurSimp = ($listre[11]);
				$StatutErreur = ($listre[12]);
				$StatutSegm = ($listre[13]);
				$Genre = ($listre[14]);
				$Nombre	= ($listre[15]);
				$BaseAdjNorm = ($listre[16]);
				$GenreAdjNorm = ($listre[17]);
				$NombreAdjNorm = ($listre[18]);
				$BaseAdjTrans = ($listre[19]);
				$GenreAdjTrans = ($listre[20]);
				$NombreAdjTrans	= ($listre[21]);
				$ErreurAdjBase = ($listre[22]);
				$ErreurAdjGenre	= ($listre[23]);
				$ErreurAdjNombre = ($listre[24]);
				$VerPers = ($listre[25]);
				$BaseVerForme = ($listre[26]);
				$DesiVerForme = ($listre[27]);
				$BaseVerProd = ($listre[28]);
				$DesiVerProd = ($listre[29]);
				$ErrVerBase	= ($listre[30]);
				$ErrVerDes= ($listre[31]);
				$ErrVerBaseEtDes= ($listre[32]);

				$data_values .= "('$IdTok','$IdProd','$Niv','$SegNorm','$SegTrans','$PhonNorm','$PhonTrans','$SyllabNorm','$SyllabTrans','$Categorie','$Lemme','$StatuErreurSimp','$StatutErreur','$StatutSegm','$Genre','$Nombre','$BaseAdjNorm','$GenreAdjNorm','$NombreAdjNorm','$BaseAdjTrans','$GenreAdjTrans','$NombreAdjTrans','$ErreurAdjBase','$ErreurAdjGenre','$ErreurAdjNombre','$VerPers','$BaseVerForme','$DesiVerForme','$BaseVerProd','$DesiVerProd	','$ErrVerBase','$ErrVerDes','$ErrVerBaseEtDes'),";
			}


			#fermer la fonction de handle et supprimer le dernier indice   
			$data_values = substr($data_values,0,-1);


			
			#fermer la fonction de handle   
			fclose($handle); 
			
			#insérer les données aux tables
			$request = "INSERT INTO `cm2_scoledit` (IdTok,IdProd,Niv,SegNorm,SegTrans,PhonNorm,PhonTrans,SyllabNorm,SyllabTrans,Categorie,Lemme,StatuErreurSimp,StatutErreur,StatutSegm,Genre,Nombre,BaseAdjNorm,GenreAdjNorm,NombreAdjNorm,BaseAdjTrans,GenreAdjTrans,NombreAdjTrans,ErreurAdjBase,ErreurAdjGenre,ErreurAdjNombre,VerPers,BaseVerForme,DesiVerForme,BaseVerProd,DesiVerProd,ErrVerBase,ErrVerDes,ErrVerBaseEtDes) VALUES $data_values";
			#call la fonction de getData 
			$database = new DataBase();
			$database->addOrDelData($request);
	 } 	
 }  
		
?>
