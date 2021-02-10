<?php
include_once "DataBase.php";
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

        switch($i) {
            case ($tabSentences[$i]['SegNorm'] == '<sent>') :
                $flag = true;
           // break;
            case ($tabSentences[$i]['SegNorm'] == '</sent>') :
                $count= $i;
           // break;
            case ($flag == false) :
                $i=$i+1;
           // break;
            case ($flag == true) :
            while (($i != $count) && ($i < count($tabSentences))) {
                $j = $i-1;
                $IdProd = $tabSentences[$i]['IdProd'];
                if (($tabSentences[$i]['Lemme'] != '<sent>') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    $phrase = $phrase. " " .$tabSentences[$i]['SegTrans'];
                    //var_dump($tabSentences[$i]);
                } elseif (($tabSentences[$i]['Categorie'] != 'SENT') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
                    if ($tabSentences[$i]['Lemme'] == '<sent>') {
						 $phrase = $phrase. "\n";
					} else {
                    $phrase = $phrase. " " .$tabSentences[$i]['SegTrans']. "\n";
				}
                }
                if ($tabSentences[$j]['IdProd'] != $IdProd) {
                    $phrase = $phrase."\n";
                }
                $i=$i+1;
            }
                $finalSentencesList = $finalSentencesList . $phrase;
        }
        return  $finalSentencesList;
    }
}
