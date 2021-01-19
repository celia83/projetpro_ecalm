<?php

include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/DataBase.php";

class StandardizedBaseOrEnding {

    public function createTabStandardizedBaseOrEnding($verbGroup, $tense){
        /**
         * Cette fonction crée un tableau qui donne le pourcentage pour chaque niveau de forme verbale normées, ayant une erreur sur la base, sur la désinence et sur les deux.
         * L'utilisateur peut choisir d'afficher le tableau en fonction d'un temps (Infinitif, Imparfait, Présent, Passé Simple) et d'un type de verbe (en -er, non en -er ou tous)
         * @param string $verbGroup    Choix du groupe du verbe (-er | non -er | tous_les_verbes)
         * @param string $tense    Choix du temps (Infinitif | Présent | Imparfait | Passé Simple)
         * @return array $finalTab
         */
        #Créer la requête
        #Normaliser le temps des verbes pour la requête sql
        if ($tense == "Présent"){
            $tenseSQL = "VER:pres";
        } elseif ($tense == "Infinitif") {
            $tenseSQL = "VER:infi";
        }elseif ($tense == "Imparfait") {
            $tenseSQL = "VER:impf";
        } elseif ($tense == "Passé simple") {
            $tenseSQL = "VER:simp";
        } else {
            $tenseSQL = "VER%";
        }

        #Sélectionner soit les verbes en -er, soit les verbes qui ne sont pas en -er, soit tous et insérer le temps voulu
        if ($verbGroup == "er") {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "'.$tenseSQL.'" AND Categorie LIKE "VER:pper" AND SegmNorm LIKE "%er"' ;;
            #Si l'utilisateur veut les verbes qui ne sont pas en er
        } elseif ($verbGroup == "nonEr"){
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "'.$tenseSQL.'" AND Categorie LIKE "VER:pper" AND SegNorm LIKE "%er" = 0' ;;
            #Si l'utilisateur veut tous les verbes
        } else {
            $request = 'SELECT Niv, ErrVerBase, ErrVerDes, ErrVerBaseEtDes FROM `cm2_scoledit` WHERE Categorie LIKE "'.$tenseSQL.'" AND Categorie LIKE "VER:pper" = 0';
        }

        #Récupération des données dans la base de données
        $database = new DataBase();
        $tabVerbs= $database->getData($request);

        #Ce tableau permettra de répartitr les verbes dans les catégories leur correspondant : le calcul se fera une fois qu'on aura trouvé à quelle catégorie appartient chaque verbe
        $verbByLevelTab = array(
            "CP" => array(
                "Normé" => array(),
                "Erreur base" => array(),
                "Erreur désinence" => array(),
                "Erreur base et désinence" => array(),
                "Total" => array()
            ),
            "CE1" => array(
                "Normé" => array(),
                "Erreur base" => array(),
                "Erreur désinence" => array(),
                "Erreur base et désinence" => array(),
                "Total" => array()
            ),
            "CE2" => array(
                "Normé" => array(),
                "Erreur base" => array(),
                "Erreur désinence" => array(),
                "Erreur base et désinence" => array(),
                "Total" => array()
            ),
            "CM1" => array(
                "Normé" => array(),
                "Erreur base" => array(),
                "Erreur désinence" => array(),
                "Erreur base et désinence" => array(),
                "Total" => array()
            ),
            "CM2" => array(
                "Normé" => array(),
                "Erreur base" => array(),
                "Erreur désinence" => array(),
                "Erreur base et désinence" => array(),
                "Total" => array()
            ));

        #Remplir le tableau
        foreach($tabVerbs as $verb){
            if ($verb["ErrVerBase"] == 1 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Erreur base"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["Total"],$verb);
            } elseif ($verb["ErrVerDes"] == 1 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Erreur désinence"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["Total"],$verb);
            }elseif ($verb["ErrVerBaseEtDes"] == 1 ){
                array_push($verbByLevelTab[$verb["Niv"]]["Erreur base et désinence"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["Total"],$verb);
            } else {
                array_push($verbByLevelTab[$verb["Niv"]]["Normé"],$verb);
                array_push($verbByLevelTab[$verb["Niv"]]["Total"],$verb);
            }
        }

        #Contiendra le tableau final avec les pourcentages
        $finalTab = array();

        #Pour chaque niveau
        foreach ($verbByLevelTab as $level => $tabError){
            #On calcule le nombre total de verbes
            $total = sizeof($tabError["Total"]);

            #On calcule le nombre de verbe normés
            $nbStandardized = sizeof($tabError["Normé"]);

            #On calcule le nombre de verbes avec une erreur sur la base
            $nbBaseErr = sizeof($tabError["Erreur base"]) ;

            ##On calcule le nombre de verbes avec une erreur sur la désinence
            $nbEndErr = sizeof($tabError["Erreur désinence"]);

            #On calcule le nombre de verbes avec une erreur sur la base et la désinence
            $nbBaseAndEndErr = sizeof($tabError["Erreur base et désinence"]) ;

            #Ajout au tableau final
            #Si on a des verbes dans la catégorie (donc total différent de 0) on calcule les pourcentages
            if ($total != 0){
                $finalTab[$level]["Normé"] = (string) $nbStandardized  / $total * 100 . "%";
                $finalTab[$level]["Erreur base"] = (string) $nbBaseErr / $total * 100 . "%";
                $finalTab[$level]["Erreur désinence"] = (string) $nbEndErr  / $total * 100 . "%";
                $finalTab[$level]["Erreur base et désinence"] = (string) $nbBaseAndEndErr / $total * 100 . "%";
                $finalTab[$level]["Total"] = (string) ($nbStandardized +  $nbBaseErr + $nbEndErr + $nbBaseAndEndErr) / $total * 100 . "%";

            #Sinon on dit à l'utilisateur qu'on n'a pas les données
            } else {
                $finalTab[$level]["Normé"] = "Pas de données";
                $finalTab[$level]["Erreur base"] = "Pas de données";
                $finalTab[$level]["Erreur désinence"] = "Pas de données";
                $finalTab[$level]["Erreur base et désinence"] = "Pas de données";
                $finalTab[$level]["Total"] = "Pas de données" ;
            }
        }

        return $finalTab;
    }

}