<?php

include_once "../DataBase.php";

class DeleteData 
{
	
	protected $corpus;
    protected $level;
    
    public function __construct($corpus, $level){

        $this->corpus=$corpus;
        $this->level=$level;
        
    }
    
	/*
     * Cette fonction permet de sélectionner dans la base de données toutes 
     * les lignes qui correspondent au CM2 et à Scoledit et les supprimer.
     */    
	
	public function supprimerData(){	

		#Normaliser les critères pour que la requête soit adaptées au données de la bdd
        $this->normalizeCriterions();
        
        #Rédiger la requête pour supprimer les données de la base de données
		$request = 'DELETE FROM `scoledit` 
WHERE IdTok LIKE "'.$this->corpus.'" 
AND Niv LIKE "'.$this->level.'"';
		
        $database = new DataBase();
        $deleteData= $database->getData($request);        			
  
	 } 
	 
	protected function normalizeCriterions(){
        #Normalisation du corpus : E : Ecriscol, S : Scoledit, R : Resolco, sinon on sélectionne tous les corpus avec %
        if ($this->corpus == "Scoledit"){
            $this->corpus = "%S%";
        } elseif ($this->corpus == "Ecriscol"){
            $this->corpus = "%E%";
        } elseif ($this->corpus == "Resolco"){
            $this->corpus = "%R%";
        } else {
            $this->corpus = "%";
        }

        }
}	  
		
?>
