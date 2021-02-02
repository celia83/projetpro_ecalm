<?php
include_once "model/DataBase.php";
class User{
    private $login;
    private $psw;

    public function __construct($login, $psw){
        $this->login = $login;
        $this->psw = $psw;
    }

    public function verifyUser(){
        $request ="SELECT `Password` FROM `users` WHERE `Login`= '".$this->login."'";
        $database = new DataBase();
        $tabpsw= $database->getData($request);
        if ($tabpsw==false) {
            return "Identifiant incorrect.";
        } else {
            if ($tabpsw[0]['Password'] == $this->psw) {
                $_SESSION['login'] = $this->login;
                return "true";
            } else {
                return "Mot de passe incorrect.";
            }
        }
    }
}