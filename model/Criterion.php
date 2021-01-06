<?php
class Criterion
{
    private $corpus;
    private $level;
    private $pos;
    private $errStatus;
    private $segmStatus;
    private $lemma;

    public function Criterion($corpus, $level, $pos, $errStatus, $segmStatus, $lemma){
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