<?php


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
        var_dump($request);
        #Connexion à la base de données
        $db = self::connexion();

        #Requêter la base
        $response = $db->query($request);

        #Récupérer les informations de la requête (le mode PDO::FETCH_ASSOC permet d'éviter que le résultats de dédouble les colonnes)
        $tab = array();
        while($enr=$response->fetch(PDO::FETCH_ASSOC)) {
            array_push($tab, $enr);
        }
        #$tab = $response->fetch();
        #var_dump($tab);
        return $tab;
    }

    public function normalizeCriterions(){
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
        } elseif ($this->tense == "Passé simple"){ #ATTENTION : Conjonctions de coordination et de subordination sont traitées de la même manière avec Treetagger
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