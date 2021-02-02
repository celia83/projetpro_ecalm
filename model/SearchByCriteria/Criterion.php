<?php

include_once "model/DataBase.php";

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

    /**
     * Cette fonction permet de retourner un tableau en fonction des critères sélectionnés par l'utilisateur
     * @return array $tab contenant les lignes retournées par la requête
     */
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

        $request = 'SELECT * FROM `cm2_scoledit` 
WHERE IdTok REGEXP "'.$this->corpus.'" 
AND Niv LIKE "'.$this->level.'" 
AND Categorie LIKE "'.$this->pos.'" 
AND StatutErreur LIKE "'.$this->errStatus.'" 
AND StatutSegm LIKE "'.$this->segmStatus.'" 
AND Lemme LIKE "'.$this->lemma.'"';


        $database = new DataBase();
        $tab= $database->getData($request);
        $finalTab =$this->addScanLink($tab);
        return $finalTab;
    }

    /**
     * Les données provenant de la page HTML sont dans un format agréable à lire pour l'utilisateur, cette fonction permet de transcrire ces données
     * pour qu'elles correspondent à ce qu'on a dans la base de données
     * @return void
     */
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

        #Normalisation des catégories grammaticales
        if ($this->pos == "Adverbe"){
            $this->pos = "ADV";
        } elseif ($this->pos == "Adjectif"){
            $this->pos = "ADJ";
        } elseif ($this->pos == "Verbe"){
            $this->pos = "VER%";
        } elseif ($this->pos == "Nom"){
            $this->pos = "NOM";
        } elseif ($this->pos == "Noms propre"){
            $this->pos = "NAM";
        } elseif ($this->pos == "Déterminant") {
            $this->pos = "DET%";
        } elseif ($this->pos == "Pronom"){
            $this->pos = "PRO%";
        } elseif ($this->pos == "Préposition"){
            $this->pos = "PRP%";
        } elseif ($this->pos == "Conjonction"){ #ATTENTION : Conjonctions de coordination et de subordination sont traitées de la même manière avec Treetagger
            $this->pos = "KON";
        } elseif ($this->pos == "Abréviation"){
            $this->pos = "ABR";
        } elseif ($this->pos == "Chiffre"){
            $this->pos = "NUM";
        } elseif ($this->pos == "Interjection"){
            $this->pos = "INT";
        } else {
            $this->pos = "%";
        }

        #Normalisation des Statuts d'erreur (la terminologie reste la même si ce n'est les numéros qui précèdent le mot par ex "01-Normé" donc on peut simplement ajouter % devant)
        if ($this->errStatus == "Tous"){
            $this->errStatus = "%";
        } else {
            $this->errStatus = "%".$this->errStatus ."%";
        }


        #Normalisation des Status de segments (la situation est la même que pour le statut des erreurs)
        if ($this->segmStatus == "Tous"){
            $this->segmStatus = "%";
        } else {
            $this->segmStatus = "%" . $this->segmStatus . "%";
        }

        #Normalisation du lemme (si on n'a pas de lemme précisé on les sélectionne tous avec %)
        if($this->lemma == ""){
            $this->lemma = "%";
        }

        #Normalisation du niveau
        if ($this->level == "Tous"){
            $this->level = "%";
        }
    }

    public function addScanLink($result){
        $newResults = array(); #Contiendra les nouvelles lignes de résultat
        #Sélectionner une ligne d'informations
        for ($i =0; $i < count($result);$i++){
            $line = $result[$i];
            //var_dump($line);
            #Reconstituer le chemin vers l'image
            $scanURL = "public/assets/scans/".$line["Niv"]."/". $line["IdTok"].".jpg";
            //var_dump($scanURL);
            #Vérifier que l'image existe
            if (file_exists($scanURL)){
                #Si elle existe on et le lien vers l'image
                $scan="<a href = '".$scanURL."' target='_blank'>Lien vers le scan</a>";
            } else {
                #Sinon on précise qu'il est indisponible
                $scan="Scan indisponible";
            }
            #On ajoute le scan à la fin de la ligne
            $line["Scan"]=$scan;
            #Ajouter la nouvelle line au nouveau tableau
            array_push($newResults, $line);
        }
        return $newResults;
    }
}