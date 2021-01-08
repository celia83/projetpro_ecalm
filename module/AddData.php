<?php
//connection à la BD
$servername = "localhost";
$username = "scoledit";
$password = "projetpro";
$dbname = "scoledit";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
} 
//traiter le fichier
	function input_csv($handle)   
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
	$action = $_GET['action'];   
	
		//la fonction d'inserer
		if ($action == 'import') { 
			$filename = $_FILES['file']['tmp_name'];   
			if(empty ($filename))   
			{   
				echo 'Sélection le fichier en format de csv :';   
				exit;   
			}   
			$handle = fopen($filename, 'r');   
			
			$result = input_csv($handle); //traiter le fichier de csv   
			
			$len_result = count($result);   
			if($len_result==0)   
			{   
				echo 'Rien dans ce fichier !';   
				exit;   
			}   
			
			for($i = 1; $i < $len_result; $i++) //un boucle pour obtenir les valeurs   
			{   

				//split chaque ligne par ';'
				$listre =  explode (';',implode($result[$i])); 
				
				//trouver les valeurs des colonnes 
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
			$data_values = substr($data_values,0,-1); //supprimer le dernier indice
			
			fclose($handle); //fermer la fonction de handle   
			
			//insérer les données aux tables
			$sql = "INSERT INTO `CM2_Scoledit` (IdTok,IdProd,Niv,SegNorm,SegTrans,PhonNorm,PhonTrans,SyllabNorm,SyllabTrans,Categorie,Lemme,StatuErreurSimp,StatutErreur,StatutSegm,Genre,Nombre,BaseAdjNorm,GenreAdjNorm,NombreAdjNorm,BaseAdjTrans,GenreAdjTrans,NombreAdjTrans,ErreurAdjBase,ErreurAdjGenre,ErreurAdjNombre,VerPers,BaseVerForme,DesiVerForme,BaseVerProd,DesiVerProd,ErrVerBase,ErrVerDes,ErrVerBaseEtDes) VALUES $data_values";
			
			
			if ($conn->query($sql) === TRUE) {
				echo "Succès !";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}  
		}  
		
 
?>
