<!DOCTYPE html>
<html>
    <head>
        <!-- Entête de la page-->
        <title>E-Calm</title>
        <meta charset="UTF-8"/> <!-- dit en quel encodage je suis-->
        <link rel="stylesheet" href = "css/style.css"/> <!-- donne la feuille de style en css utilisée-->
        <script type="text/javascript" src="jquery-3.4.1.js"></script> <!--appel de JQuery-->
    </head>
    <body>
        <header>
            <img id = "logo_lidilem" src="assets/img/logo_LIDILEM_CMJN.jpg"/>
            <img id = "logo_ecalm" src="assets/img/Ecalm_logo_transparent.png"/>
            <section id="connexion">Connexion</section>
        </header>
        <!-- Fonction de entrer les données du fichier de csv-->
        <form id="addform" action="http://i3l.univ-grenoble-alpes.fr/~scoledit/projetpro_ecalm/module/AddData.php?action=import" method="post" enctype="multipart/form-data"> 
			<p>Sélection le fichier en format de csv : <br/><input type="file" name="file"> <input type="submit"  class="btn" value="inserer_CSV">  
			
			</p>  
		</form>  
		
    </body>

</html>
