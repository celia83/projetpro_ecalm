<?php
require("User.php");
$userVerification = new User("scoledit", "projetpro");
var_dump($userVerification->verifyUser());