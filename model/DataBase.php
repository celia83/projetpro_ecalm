<?php

class DataBase {

    /**
     * Permet la connexion à la base de données
     * @return PDO $db
     */
    private static function connection(){
        if($db = new PDO('mysql:host=localhost;dbname=scoledit', 'scoledit', 'projetpro', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'))){
            return $db;
        } else {
            throw new Exception('Impossible de se connecter à la base de données.');
        }
    }

    /**
     * Fonction qui se connecte à une base de données, éxecute la requête passée en paramètre et retourne un tableau des éléments ainsi sélectionnésù
     * @param string $request
     * @return array $tab un tableau contenant le résultat de la requête
     */
    public function getData($request){
        #Connexion à la base de données
        $db = self::connection();
        #Requêter la base
        if ($response = $db->query($request)){
            #Récupérer les informations de la requête (le mode PDO::FETCH_ASSOC permet d'éviter que le résultats ne dédouble les colonnes)
            $tab = array();
            while ($enr = $response->fetch(PDO::FETCH_ASSOC)) {
                array_push($tab, $enr);
            }
            return $tab;
        } else {
            throw new Exception('Impossible de récupérer les données.');
        }
    }

    public function addOrDelData($request){
        #Connexion à la base de données
        $db = self::connection();
        #Requêter la base
        if ($nbLineAffected = $db->exec($request)){
            return $nbLineAffected;
        } else {
            throw new Exception('Impossible de récupérer les données.');
        }
    }
}


