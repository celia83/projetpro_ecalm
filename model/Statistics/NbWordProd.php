<?php

include_once "../connection.php";

class NbWordProd
{
    /*
     * Cette fonction sélectionne seulement les mots dans la bdd et les compte (hors ponctuations et balises)
     * @return int $countWords un entier représentant le nombre de mots présents dans la bdd
     */
    public function countWords(){
        #Sélectionner seulement les mots dans la base de données (pas de ponctuation et de balises telles que <sent>)
        $request = "SELECT SegNorm FROM `cm2_scoledit` WHERE SegNorm REGEXP '^<' = 0 AND SegNorm REGEXP '[a-zA-Z]'";

        #Récupération des données dans la base de données
        $database = new DataBase();
        $tabWords= $database->getData($request);

        #On compte le nombre de mots
        $countWords = sizeof($tabWords);

        return $countWords;
    }
}