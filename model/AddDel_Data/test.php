<?php
include "InsertData.php";
include "DeleteData.php";

//$insertdate = new InsertData();
//var_dump($insertdate->inserercsv("2_CM2_Scoledit.CSV") );

$supprimerdate = new DeleteData("Scoledit", "CM2");
var_dump($supprimerdate->supprimerData() );
