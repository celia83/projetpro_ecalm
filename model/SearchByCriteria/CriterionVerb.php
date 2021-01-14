<?php

include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/DataBase.php";

class CriterionVerb extends Criterion{

    private $tense;
    private $person;
    private $typeErr;
    private $desinence;
    private $base;

    public function __construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma,$tense, $person, $typeErr, $desinence, $base){

        parent::__construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
        $this->tense=$tense;
        $this->person=$person;
        $this->typeErr=$typeErr;
        $this->desinence=$desinence;
        $this->base=$base;

    }

    /**
     * Cette fonction permet de retourner un tableau en fonction des critères sélectionnés par l'utilisateur
     * @return array $tab contenant les lignes retournées par la requête
     */
    public function getResultsVerb(){
        /* Exemple de requete qui fonctionne avec les critères principaux (pour le corpus on recherche S dans idTok pour le corpus Scoledit:
         SELECT * FROM `CM2_Scoledit`
         WHERE IdTok LIKE "%S%"
         AND Niv LIKE "CM2"
         AND Categorie LIKE "NOM"
         AND StatutErreur LIKE "01-Norm%"
         AND StatutSegm LIKE "01-Norm%"
         And Lemme LIKE "fois"
         */

        #Normaliser les critères pour que la requête soit adaptées au données de la bdd
        $this->normalizeCriterions();

        #Rédiger la requête (pour les verbes la catégorie et le tiroir verbal sont les mêmes donc on sélectionne soit tous les verbes soit les verbes au conditionnel etc. dans la partie "Catégorie
        $request = 'SELECT * FROM `cm2_scoledit` 
WHERE IdTok LIKE "'.$this->corpus.'" 
AND Niv LIKE "'.$this->level.'" 
AND Categorie LIKE "'.$this->tense.'"
AND StatutErreur LIKE "'.$this->errStatus.'" 
AND StatutSegm LIKE "'.$this->segmStatus.'" 
AND Lemme LIKE "'.$this->lemma.'" 
AND VerPers LIKE "'.$this->person.'" 
AND BaseVerForme LIKE "'.$this->base.'" 
AND DesiVerForme LIKE "'.$this->desinence.'"'.$this->typeErr;

        $database = new DataBase();
        $tab= $database->getData($request);

        return $tab;
    }

    /**
     * Les données provenant de la page HTML sont dans un format agréable à lire pour l'utilisateur, cette fonction permet de transcrire ces données
     * pour qu'elles correspondent à ce qu'on a dans la base de données
     * @return void
     */
    protected function normalizeCriterions(){
        parent::normalizeCriterions();

        #Normaliser les tiroirs verbaux
        if ($this->tense == "Conditionnel"){
            $this->tense = "VER:cond";
        } elseif ($this->tense == "Futur"){
            $this->tense = "VER:futu";
        } elseif ($this->tense == "Impératif"){
            $this->tense = "VER:impe";
        } elseif ($this->tense == "Imparfait"){
            $this->tense = "VER:impf";
        } elseif ($this->tense == "Infinitif") {
            $this->tense = "VER:infi";
        } elseif ($this->tense == "Participe présent"){
            $this->tense = "VER:ppre";
        } elseif ($this->tense == "Présent"){
            $this->tense = "VER:pres";
        } elseif ($this->tense == "Passé simple"){
            $this->tense= "VER:simp";
        } elseif ($this->tense== "Subjonctif imparfait"){
            $this->tense = "VER:subi";
        } elseif ($this->tense== "Subjonctif présent"){
            $this->tense = "VER:subp";
        } else {
            $this->tense = "VER%";
        }

        #Normaliser les personnes
        if ($this->person == "1S"){
            $this->person = "1P%";
        } elseif ($this->person == "2S"){
            $this->person = "2P%";
        } elseif ($this->person == "3S"){
            $this->person = "3P";
        } elseif ($this->person == "1P"){
            $this->person = "4P";
        } elseif ($this->person == "2P") {
            $this->person = "5P";
        } elseif ($this->person == "3P"){
            $this->person = "6P";
        } else {
            $this->person = "%";
        }

        #Normaliser les types d'erreur
        if ($this->typeErr == "Erreur Base"){
            $this->typeErr = ' AND ErrVerBase LIKE "1"';
        } elseif ($this->typeErr== "Erreur Désinence") {
            $this->typeErr = ' AND ErrVerDes LIKE "1"';
        } elseif ($this->typeErr== "Erreur Base et Désinence"){
            $this->typeErr= ' AND ErrVerBaseEtDes LIKE "1"';
        } else {
            $this->typeErr = ' AND ErrVerBase LIKE "0" AND ErrVerDes LIKE "0" AND ErrVerBaseEtDes LIKE "0"';
        }

        #Normaliser la base
        if($this->base == ""){
            $this->base = "%";
        }

        #Normaliser la désinence
        if($this->desinence == ""){
            $this->desinence = "%";
        }
    }
}