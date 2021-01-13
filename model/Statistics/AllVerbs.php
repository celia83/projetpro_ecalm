<?php

include_once "../DataBase.php";

class AllVerbs 
{
    /*
     *  /*
     * Cette fonction sélectionne tous les verbes dans la base de données et donne le nombre de bases et de désinences.
     * Les résultats sont affichés dans un tableau.
     * @return array $percentageAllVerbsByLevel
     */
 
    public function createTabAllVerbs() {
        $request = 'SELECT Niv, Categorie, BaseVerForme, DesiVerForme, DesiVerProd FROM `cm2_scoledit` WHERE Categorie LIKE "VER%" ';
      
        #Récupération des données dans la base de données
        $database = new DataBase();
        $tabVerbs= $database->getData($request);

        #Contiendra par niveau le nombre de formes verbales, de bases et de désinences par niveau
        $VerbalFormsByLevel = array(
            "CP" => array(
                "Nombre de formes verbales" => 0,
				"Nombre de bases" => 0,
				"Nombre de désinences" => 0,
               ),
            "CE1" => array(
                "Nombre de formes verbales" => 0,
				"Nombre de bases" => 0,
				"Nombre de désinences" => 0,
				),
            "CE2" => array(
				"Nombre de formes verbales" => 0,
				"Nombre de bases" => 0,
				"Nombre de désinences" => 0,
                ),
            "CM1" => array(
                "Nombre de formes verbales" => 0,
				"Nombre de bases" => 0,
				"Nombre de désinences" => 0,
                ),
            "CM2" => array(
                "Nombre de formes verbales" => 0,
				"Nombre de bases" => 0,
				"Nombre de désinences" => 0,
                ),
            );
        #Sélection
        foreach ($tabVerbs as $Verbs){
            if (($Verbs["Categorie"] == "VER:impf") or ($Verbs ["Categorie"] == "VER:simp")or ($Verbs ["Categorie"] == "VER:pres") or ($Verbs ["Categorie"] == "VER:infi") or ($Verbs ["Categorie"] == "VER:cond") or ($Verbs ["Categorie"] == "VER:impe") or ($Verbs ["Categorie"] == "VER:futu") or ($Verbs ["Categorie"] == "VER:subi") or ($Verbs ["Categorie"] == "VER:subp") or ($Verbs["Categorie"] == "VER:ppre") or ($Verbs["Categorie"] == "VER:pper")){
                $VerbalFormsByLevel[$Verbs["Niv"]]["Nombre de formes verbales"] ++;
            } 
            if ($Verbs["BaseVerForme"] != "_" ){
				$VerbalFormsByLevel[$Verbs["Niv"]]["Nombre de bases"] ++;
            } 
            if($Verbs["DesiVerProd"] != "_") {
				$VerbalFormsByLevel[$Verbs["Niv"]]["Nombre de désinences"] ++;
			}
				



        #Création du tableau final
        $percentageAllVerbsByLevel = array("CP" => array(),"CE1" => array(),"CE2" => array(),"CM1" => array(),"CM2" => array());
		
        #Pour chaque niveau on compte le nombre de chaque lignes
        foreach($VerbalFormsByLevel as $level => $tab1){
            foreach($tab1 as $NivVerb => $nbVerb) {
                 $percentageAllVerbsByLevel[$level][$NivVerb] =(string) $nbVerb;
                }
        }
        
		
	
	}
        return $percentageAllVerbsByLevel;
    }
}




