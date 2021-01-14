<?php
require('controller/homeController.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'showGeneralResults') {
            showResultsCriteria($_POST["corpus"], $_POST["level"], $_POST["pos"], $_POST["errStatus"], $_POST["segmStatus"], $_POST["lemma"]);
        }
    } else {
        require('view/home.php');
    }
}catch(Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }