<?php
//require("User.php");
//$userVerification = new User("scoledit", "projetpro");
//var_dump($userVerification->verifyUser());

require("Export.php");
$Verification = new Export("le",10);
var_dump($Verification->sentences());
