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
     * Fonction sentences() : téléchargement de l'exemplier.
     *
     * Cette fonction permet de télécharger un nombre de phrases d'exemples choisies par l'utilisateur contenant le mot sélectionné.
     *
     * @return string $finalSentencesList La liste des phrases contenant le mot choisi par l'utilisateur. Le nombre de lignes est sélectionné par l'utilisateur.

     */
    
    public function sentences() {
        
        // Requête pour sélectionner les productions dans lesquelles apparaissent le lemme sélectionné limité au nombre de lignes sélectionné par l'utilisateur.
		$request="SELECT * FROM `cm2_scoledit` WHERE IdProd IN (SELECT * FROM (SELECT DISTINCT IdProd FROM `cm2_scoledit` WHERE `Lemme`= '".$this->word."' LIMIT ".$this->nbLine.") AS temp)";
		
		// Récupération des données
		$database = new DataBase();
		$tabSentences =$database->getData($request);

		$i=0;
		$flag = false;
		$phrase="";
		$finalSentencesList ="";
		$SentencesList ="";
		
		// Traitement pour sélectionner les phrases contenant le mot sélectionné 
        switch($i) {
			
			
            case ($tabSentences[$i]['SegNorm'] == '</sent>') :
                $count= $i;
            case ($flag == false) :
                $i=$i+1;
            case ($flag == true) :
            while (($i != $count) && ($i < count($tabSentences))) {
                $j = $i-1;
                $IdProd = $tabSentences[$i]['IdProd'];
                // Récupération des phrases
                if (($tabSentences[$i]['Lemme'] != '<sent>') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    $phrase = $phrase. " " .$tabSentences[$i]['SegTrans'];
                } elseif (($tabSentences[$i]['Categorie'] != 'SENT') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    if ($tabSentences[$i]['Lemme'] == '<sent>') {
						 $phrase = $phrase. "\n";
						 
					} else {
						$phrase = $phrase. " " .$tabSentences[$i]['SegTrans']. "\n";
				}
                }
                // Saut de ligne quand on change de production
                if ($tabSentences[$j]['IdProd'] != $IdProd) {
                    $phrase = $phrase."\n";
                }
                $i=$i+1;
            }
			$SentencesList = $SentencesList . $phrase;
			$sent = explode("\n", $SentencesList);
			for ($h=0; $h<=count($sent)-1;$h++) {
				// Vérification que le mot sélectionné est dans la phrase et que le nombre de lignes n'est pas dépassé
				if ((strpos($sent[$h], $this->word) == True) && ($h <= $this->nbLine)) {
					$finalSentencesList = $finalSentencesList . $sent[$h] . "\n";
				}
				// Enlever les balises restantes des phrases
				if (($h <= $this->nbLine) && ((strpos($sent[$h], '<sent>'==True)) || ((strpos($sent[$h], '</sent>') == True)))) {
					$finalSentencesList = str_replace("<sent>","",$finalSentencesList);
					$finalSentencesList = str_replace("</sent>","",$finalSentencesList);
				}
			}
        }
        return  $finalSentencesList;
    }
}
