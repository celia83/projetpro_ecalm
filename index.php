<?php
require('controller/HomeController.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'showGeneralResults') {
            $controller = new HomeController();
            $controller->showResultsCriteria($_POST["corpus"], $_POST["level"], $_POST["pos"], $_POST["errStatus"], $_POST["segmStatus"], $_POST["lemma"]);
        } else {
            echo "Error 404 : page non trouvée";
        }
    } else {
        $controller = new HomeController();
        $controller->home();
    }
}catch(Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }