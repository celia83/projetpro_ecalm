<!DOCTYPE html>
<html>
    <head>
        <!-- Entête de la page-->
        <title>E-Calm</title>
        <meta charset="UTF-8"/> <!-- dit en quel encodage je suis-->
        <link rel="stylesheet" href = "../public/css/style.css"/> <!-- donne la feuille de style en css utilisée-->
        <script type="text/javascript" src="../public/js/jquery-3.4.1.js"></script> <!--appel de JQuery-->
        <script src="../public/js/script.js"></script> <!--Appel du script javascript-->
    </head>
    <body>
        <header>
            <img alt="logo_lidilem" id = "logo_lidilem" src="../public/assets/img/logo_LIDILEM_CMJN.jpg"/>
            <img alt="logo_ecalm" id = "logo_ecalm" src="../public/assets/img/Ecalm_logo_transparent.png"/>
            <div id="connectionArea">
                <a href="../index.php?action=connectionPage">Connexion</a>
            </div>
        </header>
        <article id="connexionArticle">
            <h1 id="connectionTitle">Connexion</h1>
            <div id="alerts">

            </div>
            <form id = "connectionForm" action="../index.php?action=connection" method="POST">
                <div id ="loginDiv">
                    <label for="login" >Identifiant : </label>
                    <input id="login" type = "text" name="login"/>
                </div>
                <div id = "pswDiv">
                    <label for="psw">Mot de passe : </label>
                    <input id="psw" type = "password" name = "psw"/>
                </div>
                <div id="bouton_connexion">
                    <label for ="submitButton"></label>
                    <input id="connectionButton" type="submit" value="Connexion"/>
                </div>
            </form>
        </article>

        <footer></footer>
    </body>
</html>