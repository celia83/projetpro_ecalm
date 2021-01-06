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
        self::connexion();
    }

}