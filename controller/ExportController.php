<?php

include_once "C:/wamp/www/model/Export.php";

class ExportController{


    public function Export($word,$nbLine){
        $exporter = new Export($word,$nbLine);
		$result = $exporter->sentences();
		echo json_encode($result);
    }
}
