<?php

class DataBase {

    /*
     * Permet la connexion à la base de données
     * @return le PDO $db
     */
    private static function connection(){
        try { /* tentative de connexion à la BD*/
            //$db = new PDO('mysql:host=localhost;dbname=scoledit', 'root', '');
            $db = new PDO('mysql:host=localhost;dbname=scoledit', 'scoledit', 'projetpro');
            return $db;
        } catch (Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
    }

    /*
     * Fonction qui se connecte à une base de données, éxecute la requête passée en paramètre et retourne un tableau des éléments ainsi sélectionnésù
     * @param array $request
     * @return $tab un tableau contenant le résultat de la requête
     */
    public function getData($request){
        #Connexion à la base de données
        $db = self::connection();
        #Requêter la base
        try {
            $response = $db->query($request);
            #Récupérer les informations de la requête (le mode PDO::FETCH_ASSOC permet d'éviter que le résultats de dédouble les colonnes)
            $tab = array();
            while ($enr = $response->fetch(PDO::FETCH_ASSOC)) {
                array_push($tab, $enr);
            }
        } catch (Exception $e){
            die ('Erreur : ' . $e->getMessage());
        }
        return $tab;
    }
}


