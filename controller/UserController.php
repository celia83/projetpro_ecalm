<?php
require("model/User.php");

class UserController
{
    public function connectionPage(){
        require('view/userConnection.php');
    }
    public function login($login, $mdp){
        $userVerification = new User($login, $mdp);
        $response  = $userVerification->verifyUser();
        echo json_encode($response);
    }

    public function logout(){
        session_destroy();
        header('Location:index.php');
        //require('view/home.php');
    }
}