<?php

include_once "../DataBase.php";

class StandardizedBaseOrEnding {
    public function createTabStandardizedBaseOrEnding($verbType){
        #Créer la requête
        if ($verbType == "er") {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "VER%" AND Categorie LIKE "VER:pper" AND SegmNorm LIKE "%er"' ;;
            #Si l'utilisateur veut les verbes qui ne sont pas en er
        } elseif ($verbType == "nonEr"){
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "VER%" AND Categorie LIKE "VER:pper" AND SegNorm LIKE "%er" = 0' ;;
            #Si l'utilisateur veut tous les verbes
        } else {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "VER%" AND Categorie LIKE "VER:pper" = 0';
        }

        #Récupération des données dans la base de données
        $database = new DataBase();
        $tab= $database->getData($request);

        return $tab;
    }

}