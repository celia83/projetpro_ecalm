<?php
include_once "C:/wamp/www/model/DataBase.php";

/**
 * Classe Export
 *
 * Cette classe contient la fonction nécessaire à la création de l'exemplier
 *
 * PHP version 5.6
 *
 * @author Océane Giroud <oceane.giroud@etu.univ-grenoble-alpes.fr>
 */
 
class Export {
	protected $word;
    protected $nbLine;

/**
     * Constructeur de Export.
     * @param string $word Le mot sélectionné par l'utilisateur.
     * @param string $nbLine Le nombre de lignes sélectionné par l'utilisateur.
     */
     
    public function __construct($word, $nbLine){
        $this->word = $word;
        $this->nbLine = $nbLine;
    }
    
     /**
     * Fonction sentences() : sélection des phrases pour l'exemplier.
     *
     * Cette fonction permet de sélectionner un nombre de phrases d'exemples choisies par l'utilisateur contenant le mot sélectionné.
     *
     * @return string $finalSentencesList La liste des phrases contenant le mot choisi par l'utilisateur. Le nombre de lignes est sélectionné par l'utilisateur.

     */
    
    public function sentences() {
        
        // Requête pour sélectionner les productions dans lesquelles apparaissent le lemme sélectionné limité au nombre de lignes sélectionné par l'utilisateur.
		$request="SELECT * FROM `cm2_scoledit` WHERE IdProd IN (SELECT * FROM (SELECT DISTINCT IdProd FROM `cm2_scoledit` WHERE `Lemme`= '".$this->word."' LIMIT ".$this->nbLine.") AS temp)";
		
		// Récupération des données
		$database = new DataBase();
		$tabSentences =$database->getData($request);
		
		
		$finalSentencesListLemme="";
		$finalSentencesListSegTrans="";
		$phraseSegTrans="";
		$sentencesLemme="";
		$sentencesSegTrans="";
		$sentencesListLemme="";
		$sentencesListSegTrans="";
		$j=0;
		

		// Traitement pour sélectionner les phrases contenant le mot sélectionné 
		for ($j=0; $j<=count($tabSentences)-1;$j++) {
			
			if ($tabSentences[$j]['SegTrans'] == '<sent>') {
				while (($tabSentences[$j]['SegTrans'] != '</sent>') && ($j<count($tabSentences)-1)) { 
					//var_dump($j); 
					$sentencesSegTrans = $sentencesSegTrans . " " . $tabSentences[$j]['SegTrans']."\n";
					$sentencesLemme = $sentencesLemme. " " .$tabSentences[$j]['Lemme']."\n"; 
					$j=$j+1;
				} 
			}
		 }
		  
		// Tout mettre à la suite :
		$sentencesSegTrans = str_replace("\n","",$sentencesSegTrans);
		$sentencesLemme = str_replace("\n","",$sentencesLemme);
		//~ var_dump($sentencesSegTrans);
		//~ var_dump($sentencesLemme);
		
		// Saut de ligne permettant de délimiter chaque phrase
		$sentencesSegTrans = str_replace("<sent>","\n",$sentencesSegTrans);
		$sentencesLemme= str_replace(["_","<sent>"],"\n",$sentencesLemme);
		//~ var_dump($sentencesSegTrans);
		//~ var_dump($sentencesLemme);
		
	
		$sentLemme =trim($sentencesLemme);
		$sent =trim($sentencesSegTrans);
		
		//~ var_dump($sent);
		//~ var_dump($sentLemme);
		
		$sent = str_replace("\r","",$sent);
		$sentLemme= str_replace("\r","",$sentLemme);
		$sent = str_replace("\t","",$sent);
		$sentLemme= str_replace("\t","",$sentLemme);
		
		
		//~ var_dump($sent);
		//~ var_dump($sentLemme);
		
		
		//~ $sentLemme = explode("\r", $sentencesLemme);
		//~ $sent = explode("\r", $sentencesSegTrans);
		//~ var_dump($sentLemme);
		//~ var_dump($sent);
		
		//~ $sentLemme=str_replace("_","<sent>",$sentencesLemme);
		//~ var_dump($sentLemme);
		$sent = explode("\n", $sentencesSegTrans);
		$sentLemme=explode("\n",$sentLemme);
		//~ var_dump($sent);
		//~ var_dump($sentLemme);
		
		// Traitement des valeurs vides
		$sent = array_filter($sent);
		$sentLemme = array_filter($sentLemme);
		//~ var_dump($sent);
		//~ var_dump($sentLemme);
		
		$Lemme=[];
		$Trans=[];
		
		for ($i=0; $i<=count($sentLemme)-1;$i++) {
			if (($sentLemme[$i] !="") && ($sentLemme[$i] !=" ")) {
				$Lemme[] = $sentLemme[$i];
				//~ var_dump($Lemme);
			}
		}
		
		for ($i=0; $i<=count($sent)-1;$i++) {
			if (($sent[$i] !="") && ($sent[$i] !=" ")) {
				$Trans[] = $sent[$i];
			}
		}
		
		//~ var_dump($Trans);
		//~ var_dump($Lemme);
		
		for ($h=0; $h<=count($Lemme)-1;$h++) {
			
			// Vérification que le mot sélectionné est dans la phrase et que le nombre de lignes n'est pas dépassé
			if (((strpos(strtolower($Lemme[$h]), $this->word)) == True) && ($h <= $this->nbLine)) {
				$finalSentencesListLemme = $finalSentencesListLemme . $Lemme[$h] . "\n";
				$finalSentencesListSegTrans = $finalSentencesListSegTrans . $Trans[$h] . "\n";
				//~ var_dump($finalSentencesListLemme);
				//~ var_dump($finalSentencesListSegTrans);
				}
			// Enlever les balises restantes des phrases
			if (($h <= $this->nbLine) && (strpos($Trans[$h], '<sent>'==True)) || (strpos($Trans[$h], '</sent>') == True) || (strpos($Trans[$h], '</titre>') == True) || (strpos($Trans[$h], '<titre>') == True) || (strpos($Trans[$h], '_') == True) || (strpos($Trans[$h], '<p/>') == True) || (strpos($Trans[$h], '<dialogue>') == True) || (strpos($Trans[$h], '</dialogue>') == True) || (strpos($Trans[$h], '<s/>') == True) || (strpos($Trans[$h], '<segmentation/>') == True) || (strpos($Trans[$h], '<unknown>') == True) || (strpos($Trans[$h], '</ajout>') == True) || (strpos($Trans[$h], '</unsure>') == True) || (strpos($Trans[$h], '<ajout>') == True) || (strpos($Trans[$h], '<omission type=&"pronom&"/>') == True) || (strpos($Trans[$h], '<nonfini/>') == True) || (strpos($Trans[$h], '<omission type=&"pronom&"/>') == True) || (strpos($Trans[$h], '<omission type=&"adjectif&"/>') == True) || (strpos($Trans[$h], '<omission type=&"nom&"/>') == True) || (strpos($Trans[$h], '<omission type=&"preposition&"/>') == True) || (strpos($Trans[$h], '<omission type=&"verbe&"/>') == True) || (strpos($sent[$h], '<p/') == True) || (strpos($Trans[$h], '<p/<dialogue>') == True) || (strpos($Trans[$h], '<re><unknown>') == True) || (strpos($Trans[$h], '<revision/>') == True) || (strpos($Trans[$h], '<unsure>') == True)) {
				$finalSentencesListSegTrans = str_replace(["<FIN>","</FIN>","</sent>","<sent>","<FIN>","<titre>","</titre>","_","<p/>","<dialogue>","</dialogue>","<s/>","<segmentation/>","<unknown>","</ajout>","<ajout>","<nonfini/>","<omission type=&'pronom&'/>","<incomprehensible/>","<omission type=&'nom&'/>","<omission type=&'adjectif&'/>","<omission type=&'preposition&'/>","<omission type=&'verbe&'/>","<p/","<p/<dialogue>","<re><unknown>","<unsure>","</unsure>","<revision/>"],"",$finalSentencesListSegTrans);
				}
			}
		return $finalSentencesListSegTrans;
		
		}
		
	}

