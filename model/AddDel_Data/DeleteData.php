<?php

include_once "model/DataBase.php";

class DeleteData 
{
	
	protected $corpus;
    protected $level;
    
    public function __construct($corpus, $level){

        $this->corpus=$corpus;
        $this->level=$level;
        
    }
    
	/**
     * Cette fonction permet de sélectionner dans la base de données toutes 
     * les lignes qui correspondent au CM2 et à Scoledit et les supprimer.
     */    
	
	public function deleteData(){

		#Normaliser les critères pour que la requête soit adaptées au données de la bdd
        $this->normalizeCriterions();
        
        #Rédiger la requête pour supprimer les données de la base de données
		$request = 'DELETE FROM `cm2_scoledit` 
WHERE IdTok REGEXP "'.$this->corpus.'" 
AND Niv LIKE "'.$this->level.'"';
		
        $database = new DataBase();
        $nbLineAffected = $database->addOrDelData($request);
        return $nbLineAffected;
	 } 
	 
	protected function normalizeCriterions(){
        #Normalisation du corpus : E : Ecriscol, S : Scoledit, R : Resolco, sinon on sélectionne tous les corpus avec %
        if ($this->corpus == "Scoledit"){
            $this->corpus = "[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-S[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+";
        } elseif ($this->corpus == "Ecriscol"){
            $this->corpus = "[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-E[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+";
        } elseif ($this->corpus == "Resolco"){
            $this->corpus = "[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-R[0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+";
        } else {
            $this->corpus = "[A-Z]+-[a-zA-Z]+[0-9]+-[0-9]+-[a-zA-Z]+-[a-zA-Z][0-9]-[a-zA-Z][0-9]+-[A-Z][0-9]-[0-9]+-[0-9]+";
        }
	}
}	  
		
?>
