<?php
require('controller/HomeController.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'showResults') {
            if($_POST["pos"] == "Verbes"){
                $controller = new HomeController();
                $controller->showResultsCriteriaVerbs($_POST["corpus"], $_POST["level"], $_POST["pos"], $_POST["errStatus"], $_POST["segmStatus"], $_POST["lemma"], $_POST["tense"], $_POST["person"], $_POST["typeErr"],$_POST["base"], $_POST["ending"]);
            } elseif ($_POST["pos"] == "Adjectifs"){
                $controller = new HomeController();
                $controller->showResultsCriteriaAdjectives($_POST["corpus"], $_POST["level"], $_POST["pos"], $_POST["errStatus"], $_POST["segmStatus"], $_POST["lemma"], $_POST["genre"], $_POST["number"], $_POST["errGenre"],$_POST["errNumber"], $_POST["baseAdj"]);
            } else {
                $controller = new HomeController();
                $controller->showResultsCriteria($_POST["corpus"], $_POST["level"], $_POST["pos"], $_POST["errStatus"], $_POST["segmStatus"], $_POST["lemma"]);
            }

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