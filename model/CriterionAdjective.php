<?php
class CriterionAdjective extends Criterion{
    private $genre;
    private $numbre;
    private $errGenre;
    private $errNumber;
    private $base;

    public function __construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma, $genre, $numbre, $errGenre, $errNumber, $base){
        Parent::__construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
        $this->genre=$genre;
        $this->numbre=$numbre;
        $this->errGenre=$errGenre;
        $this->errNumber=$errNumber;
        $this->base=$base;
    }

    public function getResultsAdjective(){
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

        #Rédiger la requête
        $request = 'SELECT * FROM `cm2_scoledit` 
WHERE IdTok LIKE "'.$this->corpus.'" 
AND Niv LIKE "'.$this->level.'" 
AND Categorie LIKE "'.$this->pos.'" 
AND StatutErreur LIKE "'.$this->errStatus.'" 
AND StatutSegm LIKE "'.$this->segmStatus.'" 
AND Lemme LIKE "'.$this->lemma.'" 
AND Genre LIKE "'.$this->genre.'" 
AND Nombre LIKE "'.$this->numbre.'" 
AND ErreurAdjGenre LIKE "'.$this->errGenre.'" 
AND ErreurAdjNombre LIKE "'.$this->errNumber.'" 
AND BaseAdjNorm LIKE "'.$this->base.'"';
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

    protected function normalizeCriterions(){
        parent::normalizeCriterions();

        #Normaliser le genre
        if ($this->genre == "Masculin"){
            $this->genre = "m";
        } elseif ($this->genre == "Féminin"){
            $this->genre = "f";
        } else {
            $this->genre = "%";
        }

        #Normaliser le nombre
        if ($this->numbre == "Singulier"){
            $this->numbre = "s";
        } elseif ($this->numbre == "Pluriel"){
            $this->numbre = "p";
        } else {
            $this->numbre = "%";
        }

        #Normaliser les erreurs de genre
        if ($this->errGenre == "Oui"){
            $this->errGenre = "1";
        } elseif ($this->errGenre== "Non"){
            $this->errGenre = "0";
        } else {
            $this->errGenre = "%";
        }

        #Normaliser les erreurs de nombre
        if ($this->errNumber == "Oui"){
            $this->errNumber  = "1";
        } elseif ($this->errNumber == "Non"){
            $this->errNumber  = "0";
        } else {
            $this->errNumber  = "%";
        }

        #Normaliser les requêtes sur la base : si on ne précise pas de base on sélectionne toutes les bases, sinon on sélectionne les entrée qui commencent par ce que l'utilisateur a indiqué
        if($this->base == ""){
            $this->base = "%";
        } else {
            $this->base=$this->base ."%";
        }
    }
}