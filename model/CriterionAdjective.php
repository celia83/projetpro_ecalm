<?php
class CriterionAdjective extends Criterion{
    private $genre;
    private $numbre;
    private $typeErrGenre;
    private $typeErrNumber;
    private $base;

    public function __construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma,$genre, $numbre, $typeErrGenre, $typeErrNumber, $base){
        Parent::__construct($corpus, $level, $pos, $errStatus, $segmStatus, $lemma);
        $this->genre=$genre;
        $this->numbre=$numbre;
        $this->typeErrGenre=$typeErrGenre;
        $this->typeErrNumber=$typeErrNumber;
        $this->base=$base;
    }

    public function getResultsAdjective(){
        /*return $this->corpus;*/
        self::connexion();
    }

}