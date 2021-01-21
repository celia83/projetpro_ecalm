<?php

include_once "model/Exporter/DownloadResults.php";

class DownLoadController{

    /**
     * Téléchargement des tableaux sur l'ordinateur de l'utilisateur
     * @param $table
     */
    function downLoadResults($table){
        $downloader = new DownloadResults();
        $downloader->downloadTables($table);
    }
}