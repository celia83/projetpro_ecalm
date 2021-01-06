<?php
class Criterion{
    protected $corpus;
    protected $level;
    protected $pos;
    protected $errStatus;
    protected $segmStatus;
    protected $lemma;

    public function __construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){
        $this->corpus=$corpus;
        $this->level=$level;
        $this->pos=$pos;
        $this->errStatus=$errStatus;
        $this->segmStatus=$segmStatus;
        $this->lemma=$lemma;
    }

    #Interrogation de la base de données
    public function getResults(){
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
        $request = 'SELECT * FROM `CM2_Scoledit` WHERE IdTok LIKE "'.$this->corpus.'" AND Niv LIKE "'.$this->level.'" AND Categorie LIKE "'.$this->pos.'" AND StatutErreur LIKE "'.$this->errStatus.'" AND StatutSegm LIKE "'.$this->segmStatus.'" AND Lemme LIKE "'.$this->lemma.'"';

        #Connexion à la base de données
        $db = self::connexion();

        #Requêter la base
        $response = $db->query($request);

        #Récupérer les informations de la requête
        $tab = $response->fetch();

        return $tab;
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

        #Normalisation des catégories grammaticales
        if ($this->pos == "Adverbe"){
            $this->pos = "ADV";
        } elseif ($this->pos == "Nom"){
            $this->pos = "NOM";
        } elseif ($this->pos == "Nom Propre"){
            $this->pos = "NAM";
        } elseif ($this->pos == "Déterminant") {
            $this->pos = "DET%";
        } elseif ($this->pos == "Pronom"){
            $this->pos = "PRO%";
        } elseif ($this->pos == "Préposition"){
            $this->pos = "PRP%";
        } elseif ($this->pos == "Conjonctions"){ #ATTENTION : Conjonctions de coordination et de subordination sont traitées de la même manière avec Treetagger
            $this->pos = "KON";
        } elseif ($this->pos == "Abréviations"){
            $this->pos = "ABR";
        } elseif ($this->pos == "Préposition"){
            $this->pos = "INT";
        } elseif ($this->pos == "Chiffres"){
            $this->pos = "NUM";
        } else {
            $this->pos = "%";
        }

        #Normalisation des Statuts d'erreur (la terminologie reste la même si ce n'est les numéros qui précèdent le mot par ex "01-Normé" donc on peut simplement ajouter % devant)
        $this->errStatus = "%".$this->errStatus;

        #Normalisation des Status de segments (la situation est la même que pour le statut des erreurs)
        $this->segmStatus = "%".$this->segmStatus;

        #Normalisation du lemme (si on n'a pas de lemme précisé on les sélectionne tous avec %)
        if($this->lemma == ""){
            $this->lemma = "%";
        }
    }

    #Connexion à la base de données
    protected static function connexion(){
        try { /* tentative de connexion à la BD*/
            $db = new PDO('mysql:host=localhost;dbname=scoledit', 'scoledit', 'projetpro');
            return $db;
        } catch (Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
    }
}