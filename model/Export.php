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

    public function __construct($word, $nbLine){
		$this->nbLine = $nbLine;
        $this->word = $word;
    }
    
    public function sentences() {
        
		$request="SELECT * FROM `cm2_scoledit` WHERE IdProd IN (SELECT * FROM (SELECT DISTINCT IdProd FROM `cm2_scoledit` WHERE `Lemme`= '".$this->word."' LIMIT ".$this->nbLine.") AS temp)";
		$database = new DataBase();
		$tabSentences =$database->getData($request);

		$i=0;
		$flag = false;
		$phrase="";
		$finalSentencesList ="";
		$SentencesList ="";

        switch($i) {
            case ($tabSentences[$i]['SegNorm'] == '</sent>') :
                $count= $i;
            case ($flag == false) :
                $i=$i+1;
            case ($flag == true) :
            while (($i != $count) && ($i < count($tabSentences))) {
                $j = $i-1;
                $IdProd = $tabSentences[$i]['IdProd'];
                if (($tabSentences[$i]['Lemme'] != '<sent>') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    $phrase = $phrase. " " .$tabSentences[$i]['SegTrans'];
                   // echo'oui';
                   // echo$phrase;
                   // var_dump($tabSentences);
                } elseif (($tabSentences[$i]['Categorie'] != 'SENT') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    if ($tabSentences[$i]['Lemme'] == '<sent>') {
						//~ $essai = $phrase;
						 $phrase = $phrase. "\n";
						 //echo 'ici';
						// echo $phrase;
						 
					} else {
						$phrase = $phrase. " " .$tabSentences[$i]['SegTrans']. "\n";
						//echo $phrase;
				}
                }
                if ($tabSentences[$j]['IdProd'] != $IdProd) {
                    $phrase = $phrase."\n";
                }
                $i=$i+1;
            }
			$finalSentencesList = $finalSentencesList . $phrase;
			$essai = explode("\n", $finalSentencesList);
			for ($h=0; $h<=count($essai)-1;$h++) {
				if ((strpos($essai[$h], $this->word) == True) && ($h <= $this->nbLine)) {
					$SentencesList = $SentencesList . $essai[$h] . "\n";
				}
				if (($h <= $this->nbLine) && ((strpos($essai[$h], '<sent>'==True)) || ((strpos($essai[$h], '</sent>') == True)))) {
					$SentencesList = str_replace("<sent>","",$SentencesList);
					$SentencesList = str_replace("</sent>","",$SentencesList);
				}
			}
        }
        return  $SentencesList;
    }
}
