<?php
require_once('model/AddDel_Data/DeleteData.php');
require_once('model/AddDel_Data/InsertData.php');

class ManagerController
{
    public function delete($corpus, $level){
        $delete = new DeleteData($corpus, $level);
        $nbLineAffected =$delete->deleteData();
        echo "<script>alert(\"Nombre de lignes affectées par la suppression : ".$nbLineAffected."\")</script>";
        require('view/home.php');
    }

    public function add($file){
        $delete = new InsertData();
        $nbLineAffected =$delete->addCSV($file);
        echo "<script>alert(\"Nombre de lignes affectées par l'ajout: ".$nbLineAffected."\")</script>";
        require('view/home.php');
    }
}