<?php
include_once "D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/DataBase.php";
class User{
    private $login;
    private $psw;

    public function __construct($login, $psw){
        $this->login = $login;
        $this->psw = $psw;
    }

    public function verifyUser(){
        $request ="SELECT `mdp` FROM `users` WHERE `login`= '".$this->login."'";
        $database = new DataBase();
        $tabpsw= $database->getData($request);
        if ($tabpsw==false) {
            return "Identifiant incorrect.";
        } else {
            if ($tabpsw[0]['mdp'] == $this->psw) {
                $_SESSION['login'] = $this->login;
                return "true";
            } else {
                return "Mot de passe incorrect.";
            }
        }
    }
}