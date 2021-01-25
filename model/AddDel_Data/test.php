<?php
include "InsertData.php";
include "DeleteData.php";

$insertdate = new InsertData();
$insertdate->addCSV("D:/Documents/Applications/Wamp/www/projet_utils/extrait.csv");

//$supprimerdate = new DeleteData("Scoledit", "CM2");
//var_dump($supprimerdate->supprimerData() );
