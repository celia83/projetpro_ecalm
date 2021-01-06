<?php
class Criterion{
    protected $corpus;
    protected $level;
    protected $pos;
    protected $errStatus;
    protected $segmStatus;
    protected $lemma;



    public function __construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){
        $this->$corpus=$corpus;
        $this->$level=$level;
        $this->$pos=$pos;
        $this->$errStatus=$errStatus;
        $this->$segmStatus=$segmStatus;
        $this->$lemma=$lemma;
    }

    public function getResults(){
        self::connexion();
    }

    public static function connexion(){
        try { /* tentative de connexion à la BD*/
            $bdd = new PDO('mysql:host=localhost;dbname=scoledit', 'scoledit', 'projetpro');
            return $bdd;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}