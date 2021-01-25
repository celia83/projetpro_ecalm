<?php
require("D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/AddDel_Data/DeleteData.php");
require("D:/Documents/Applications/Wamp/www/projetpro_ecalm/model/AddDel_Data/InsertData.php");

class ManagerController
{
    public function delete($corpus, $level){
        $delete = new DeleteData($corpus, $level);
        $delete->deleteData();
        header('Location:index.php');
    }

    public function add($file){
        $delete = new InsertData();
        $delete->addCSV($file);
        header('Location:index.php');
    }
}