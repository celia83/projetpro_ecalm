<?php
include_once "C:/wamp/www/model/DataBase.php";
class Export{
	private $nbLine;
    protected $word;

    public function __construct($word, $nbLine){
		$this->nbLine = $nbLine;
        $this->word = $word;
    }
    
    public function sentences() {
		$request ="SELECT * FROM `cm2_scoledit` WHERE `Lemme`= '".$this->word."' BETWEEN '<sent>' AND '</sent>' 
		CASE
			WHEN '".$this->nbLine."'=10 THEN LIMIT 10
			WHEN '".$this->nbLine."'=20 THEN LIMIT 20
			WHEN '".$this->nbLine."'=30 THEN LIMIT 30
			WHEN '".$this->nbLine."'=40 THEN LIMIT 40
			WHEN '".$this->nbLine."'=50 THEN LIMIT 50
		END";
		$database = new DataBase();
		$tabSentences = $database->getData($request);
		
			
	}
}
