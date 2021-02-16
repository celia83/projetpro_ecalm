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
		
		var_dump(count($tabSentences));

		// Traitement pour sélectionner les phrases contenant le mot sélectionné 
		for ($j=0; $j<=count($tabSentences)-1;$j++) {
			if ($tabSentences[$j]['SegTrans'] == '<sent>') {
				while (($tabSentences[$j]['SegTrans'] != '</sent>') && ($j<=count($tabSentences)-2)) {
					$sentencesSegTrans = $sentencesSegTrans . " " . $tabSentences[$j]['SegTrans'];
					$sentencesLemme = $sentencesLemme. " " .$tabSentences[$j]['Lemme']; 
					$j=$j+1;
				} 
			}
		 }
		  
		  
		
		// Saut de ligne permettant de délimiter chaque phrase
		$sentencesSegTrans = str_replace("<sent>","\n",$sentencesSegTrans);
		$sentencesSegLemme= str_replace(["<sent>","_"],"\n",$sentencesLemme);
		 //~ var_dump($sentencesSegTrans);
		//~ var_dump($sentencesSegLemme);
		
		$sentLemme =$sentencesSegLemme;
		$sent =$sentencesSegTrans;
		
		//~ $sentLemme = explode("\r", $sentencesLemme);
		//~ $sent = explode("\r", $sentencesSegTrans);
		//~ var_dump($sentLemme);
		
		$sentLemme=str_replace("_","<sent>",$sentencesLemme);
		$sent = explode("\n", $sentencesSegTrans);
		$sentLemme=explode("<sent>",$sentLemme);
		//~ var_dump($sentLemme);
		//~ var_dump($sent);
		
		for ($h=0; $h<=count($sentLemme)-1;$h++) {
			// Vérification que le mot sélectionné est dans la phrase et que le nombre de lignes n'est pas dépassé
			if ((strpos(strtolower($sentLemme[$h]), $this->word) == True) && ($h <= $this->nbLine)) {
				//~ var_dump($sentLemme[$h]);
				$finalSentencesListLemme = $finalSentencesListLemme . $sentLemme[$h] . "\n";
				$finalSentencesListSegTrans = $finalSentencesListSegTrans . $sent[$h] . "\n";
				}
			// Enlever les balises restantes des phrases
			if (($h <= $this->nbLine) && (strpos($sent[$h], '<sent>'==True)) || (strpos($sent[$h], '</sent>') == True) || (strpos($sent[$h], '</titre>') == True) || (strpos($sent[$h], '<titre>') == True) || (strpos($sent[$h], '_') == True) || (strpos($sent[$h], '<p/>') == True) || (strpos($sent[$h], '<dialogue>') == True) || (strpos($sent[$h], '</dialogue>') == True) || (strpos($sent[$h], '<s/>') == True) || (strpos($sent[$h], '<segmentation/>') == True) || (strpos($sent[$h], '<unknown>') == True) || (strpos($sent[$h], '</ajout>') == True) || (strpos($sent[$h], '</unsure>') == True) || (strpos($sent[$h], '<ajout>') == True) || (strpos($sent[$h], '<omission type=&"pronom&"/>') == True) || (strpos($sent[$h], '<nonfini/>') == True) || (strpos($sent[$h], '<omission type=&"pronom&"/>') == True) || (strpos($sent[$h], '<omission type=&"adjectif&"/>') == True) || (strpos($sent[$h], '<omission type=&"nom&"/>') == True) || (strpos($sent[$h], '<omission type=&"preposition&"/>') == True) || (strpos($sent[$h], '<omission type=&"verbe&"/>') == True) || (strpos($sent[$h], '<p/') == True) || (strpos($sent[$h], '<p/<dialogue>') == True) || (strpos($sent[$h], '<re><unknown>') == True) || (strpos($sent[$h], '<revision/>') == True) || (strpos($sent[$h], '<unsure>') == True)) {
				$finalSentencesListSegTrans = str_replace(["<FIN>","</FIN>","</sent>","<sent>","<FIN>","<titre>","</titre>","_","<p/>","<dialogue>","</dialogue>","<s/>","<segmentation/>","<unknown>","</ajout>","<ajout>","<nonfini/>","<omission type=&'pronom&'/>","<incomprehensible/>","<omission type=&'nom&'/>","<omission type=&'adjectif&'/>","<omission type=&'preposition&'/>","<omission type=&'verbe&'/>","<p/","<p/<dialogue>","<re><unknown>","<unsure>","</unsure>","<revision/>"],"",$finalSentencesListSegTrans);
				}
			}
		return $finalSentencesListSegTrans;
		
		}
		
	}

