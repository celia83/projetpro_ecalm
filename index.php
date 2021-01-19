<?php
require('controller/HomeController.php');

try {
    if (isset($_GET['action'])) {
        #Controleurs pour afficher les résultats de la partie interrogation de la base
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
        #Controleurs pour afficher les résultats des tableaux de stats
        } elseif ($_GET['action'] == 'showStats'){
            $controller = new HomeController();
            $controller -> showStatsTab($_POST["tabName"], $_POST["verbGroup"], $_POST["tense"]);
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