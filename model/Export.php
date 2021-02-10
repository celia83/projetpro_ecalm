<?php
include_once "C:/wamp/www/model/DataBase.php";
class Export{
	protected $word;
    protected $nbLine;

    public function __construct($word, $nbLine){
		$this->nbLine = $nbLine;
        $this->word = $word;
    }
    
    public function sentences() {
		$request="SELECT * FROM `cm2_scoledit` WHERE IdProd IN (SELECT * FROM (SELECT DISTINCT IdProd FROM `cm2_scoledit` WHERE `Lemme`= '".$this->word."' LIMIT ".$this->nbLine.") AS temp)";
		$database = new DataBase();
		$tabSentences = [];
		
		
		foreach ($database->getData($request) as $row) {
			$tabSentences[] = $row;
		}
		
		$j=0;
		$i=0;
		$flag = false;
		$phrase="";

			switch($i) {
				case ($tabSentences[$i]['SegNorm'] == '<sent>') :
					$flag = true;
				
			
				case ($tabSentences[$i]['SegNorm'] == '</sent>') :
					$count= $i;
				
				case ($flag == false) :
					$i=$i+1;
			
			
				case ($flag == true) :

					while (($i != $count) && ($i < count($tabSentences))) {
						$j = $i-1;
						$IdProd = $tabSentences[$i]['IdProd'];
						if (($tabSentences[$i]['Lemme'] != '<sent>') && ($tabSentences[$i]['Lemme'] != '</sent>') && ($tabSentences[$i]['Lemme'] != '<FIN>')){
							$phrase = $phrase. " " .$tabSentences[$i]['Lemme'];
							//var_dump($tabSentences[$i]);
							
							
						}
						
						
						if ($tabSentences[$j]['IdProd'] != $IdProd) {
							$phrase = $phrase."\n";
						}
					$i=$i+1;
				}
				var_dump($phrase);
				$i=$i+1;
	
}
}
}
