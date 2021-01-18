<?php

include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/DataBase.php";

class StandardizedBaseEndingProportion {
    public function createTabStandardizedBaseEndingProportion($verbGroup, $tense)
    {
        /**
         * Crée le tableau des proportions de bases et désinences normées.
         * L'utilisateur peut choisir entre les verbes en er ou non et entre les quatre temps (infinitif, présent, imparfait, passé simple)
         * @param string $verbGroup    Choix du groupe du verbe (-er | non -er | tous_les_verbes)
         * @param string $tense    Choix du temps (Infinitif | Présent | Imparfait | Passé Simple)
         * @return array $finalTab
         */
        #Créer la requête
        #Normaliser le temps des verbes pour la requête sql
        if ($tense == "Présent") {
            $tenseSQL = "VER:pres";
        } elseif ($tense == "Infinitif") {
            $tenseSQL = "VER:infi";
        } elseif ($tense == "Imparfait") {
            $tenseSQL = "VER:impf";
        } elseif ($tense == "Passé simple") {
            $tenseSQL = "VER:simp";
        } else {
            $tenseSQL = "VER%";
        }

        #Sélectionner soit les verbes en -er, soit les verbes qui ne sont pas en -er, soit tous et insérer le temps voulu
        if ($verbGroup == "er") {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "' . $tenseSQL . '" AND Categorie LIKE "VER:pper" AND SegmNorm LIKE "%er"';;
            #Si l'utilisateur veut les verbes qui ne sont pas en er
        } elseif ($verbGroup == "nonEr") {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "' . $tenseSQL . '" AND Categorie LIKE "VER:pper" AND SegNorm LIKE "%er" = 0';;
            #Si l'utilisateur veut tous les verbes
        } else {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "' . $tenseSQL . '" AND Categorie LIKE "VER:pper" = 0';
        }

        #Récupération des données dans la base de données
        $database = new DataBase();
        $tabVerbs = $database->getData($request);

        $verbByLevelTab = array(
            "CP" => array(
                "Base normée" => array(),
                "Base erronée" => array(),
                "TotalBase" => array(),
                "Désinence normée" => array(),
                "Désinence erronée" => array(),
                "TotalDes" => array()
            ),
            "CE1" => array(
                "Base normée" => array(),
                "Base erronée" => array(),
                "TotalBase" => array(),
                "Désinence normée" => array(),
                "Désinence erronée" => array(),
                "TotalDes" => array()
            ),
            "CE2" => array(
                "Base normée" => array(),
                "Base erronée" => array(),
                "TotalBase" => array(),
                "Désinence normée" => array(),
                "Désinence erronée" => array(),
                "TotalDes" => array()
            ),
            "CM1" => array(
                "Base normée" => array(),
                "Base erronée" => array(),
                "TotalBase" => array(),
                "Désinence normée" => array(),
                "Désinence erronée" => array(),
                "TotalDes" => array()
            ),
            "CM2" => array(
                "Base normée" => array(),
                "Base erronée" => array(),
                "TotalBase" => array(),
                "Désinence normée" => array(),
                "Désinence erronée" => array(),
                "TotalDes" => array()
            ));

        foreach($tabVerbs as $verb){
            #Base Normée
            if ($verb["ErrVerBase"] == 0 && $verb["ErrVerBaseEtDes"] == 0 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Base normée"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["TotalBase"],$verb);
            #Base Erronée
            } elseif ($verb["ErrVerBase"] == 1 && $verb["ErrVerBaseEtDes"] == 1){
                array_push($verbByLevelTab[$verb["Niv"]]["Base erronée"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["TotalBase"],$verb);
           #Désinence Normée
            }elseif ($verb["ErrVerDes"] == 0 && $verb["ErrVerBaseEtDes"] == 0 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Désinence normée"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["TotalDes"],$verb);
            #Désinence Erronée
            }elseif ($verb["ErrVerDes"] == 1 && $verb["ErrVerBaseEtDes"] == 1 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Désinence erronée"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["TotalDes"],$verb);
            }
        }

        #Création du tableau final
        $finalTab = array();

        #Pour chaque niveau
        foreach ($verbByLevelTab as $level => $tabBaseDes){
            #Total de verbes à base normées et erronées
            $totalBase = sizeof($tabBaseDes["TotalBase"]);

            #Nombre de bases normées
            $nbStandardizedBase = sizeof($tabBaseDes["Base normée"]);

            #Nombre de base erronées
            $nbWrongBase = sizeof($tabBaseDes["Base erronée"]);

            #Total de verbes à désinence normées et erronées
            $totalDes = sizeof($tabBaseDes["TotalDes"]);

            #Nombre de désinences normées
            $nbStandardizedDes = sizeof($tabBaseDes["Désinence normée"]);

            #Nombre de désinences erronées
            $nbWrongDes = sizeof($tabBaseDes["Désinence erronée"]);

            #Calcul des pourcentages et ajout au tableau
            #On vérifie à chaque fois qu'on a bien un total (donc qu'on a des verbes pour faire le calcul) : éviter la division par 0
            if ($totalBase != 0) {
                $finalTab[$level]["Base normée"] = (string)$nbStandardizedBase / $totalBase * 100 . "%";
                $finalTab[$level]["Base erronée"] = (string)$nbWrongBase / $totalBase * 100 . "%";
                $finalTab[$level]["TotalBase"] = (string)($nbStandardizedBase + $nbWrongBase) / $totalBase * 100 . "%";
            }else {
                $finalTab[$level]["Base normée"] = "Pas de données";
                $finalTab[$level]["Base erronée"] = "Pas de données";
                $finalTab[$level]["TotalBase"] = "Pas de données";
            }

            if ($totalDes != 0) {
                $finalTab[$level]["Désinence normée"] = (string) $nbStandardizedDes  / $totalDes * 100 . "%";
                $finalTab[$level]["Désinence erronée"] = (string) $nbWrongDes / $totalDes * 100 . "%";
                $finalTab[$level]["TotalDes"] = (string) ($nbStandardizedDes + $nbWrongDes)  / $totalDes * 100 . "%";
            }else {
                $finalTab[$level]["Désinence normée"] = "Pas de données";
                $finalTab[$level]["Désinence erronée"] = "Pas de données";
                $finalTab[$level]["TotalDes"] = "Pas de données";
            }
        }

        return $finalTab;
    }
}