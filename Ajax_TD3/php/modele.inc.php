<?php

define("SERVEURBD", "");
define("LOGIN", "");
define("MOTDEPASSE", "");
define("NOMDELABASE", "");

function connexionBdd() {
    try {
        $pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE, LOGIN, MOTDEPASSE, $pdoOptions);
        $bdd->exec("set names utf8");
        return $bdd;
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function getListeRegions() {
    try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $requete = $bdd->query("select regions_id,region_nom from regions order by region_nom;");
        $tabRegions = array();
        // boucle de generation des <option>
        while ($ligne = $requete->fetch()) {
            array_push($tabRegions, array(
                'idRegion' => $ligne['regions_id'],
                'nomRegion' => $ligne['region_nom']
                    )
            );
        }

//libération des ressources de la requête
        $requete->closeCursor();
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabRegions);
    } catch (PDOException $ex) {    // traitemement des erreurs
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function getListeDepartementsRegions($idRegions) {
    try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $requete = $bdd->query("SELECT departement_id,departement_nom FROM departement INNER JOIN regions ON departement_region_id = :idreg ORDER BY departement_nom;");
        $requete->bindParam(":idreg", $idRegion);
        $tabDepartements = array();
        // boucle de generation des <option>
        while ($ligne = $requete->fetch()) {
            array_push($tabDepartement, array(
                'idDepartement' => $ligne['departement_id'],
                'nomDepartement' => $ligne['departement_nom']
                    )
            );
        }//libération des ressources de la requête
        $requete->closeCursor();
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabRegions);
}

function getDepartementsPourNumero($numeroDepartement){
   try{
       // connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
       // préparation de la requete paramétrée
        $requete = $bdd->query("SELECT departement_id,departement_nom FROM departement WHERE departement_code = :numDep ORDER BY departement_nom;");
        $requete->bindParam(":numDep", $numeroDepartement);
        $tabDepartements = array();
        
        while ($ligne = $requete->fetch()) {
            array_push($tabDepartement, array(
                'idDepartement' => $ligne['departement_id'],
                'nomDepartement' => $ligne['departement_nom']
                    )
            );
        }
   } catch (Exception $ex) {
       print "Erreur : " . $ex->getMessage() . "<br/>";
       die();
   }
}

function getNomDepartementFromVille($ville) {
    try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $requete = $bdd->prepare("select departement_nom from villes, departements where departements.departement_id=villes.ville_departement_id and ville_nom like :laville ;");
// remplacement des variables de la requête par les valeurs effectives
        $requete->bindParam(":laville", $ville);
//execution de la requête
        $requete->execute();
        $nomDep = array();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        if ($nbLigne == 0) {    // si pas de correspondance de nom de ville
            array_push($nomDep, "pas de departement correspondant");
        }
        if ($nbLigne == 1) {    // si une seule correspondance de nom de ville
            array_push($nomDep, $requete->fetchColumn(0));
        }
        if ($nbLigne > 1) { // si plusieurs correspondance de nom de ville
            while ($ligne = $requete->fetch()) {
                array_push($nomDep, $ligne['departement_nom']);
            }
        }
//libération des ressources de la requête
        $requete->closeCursor();
//retourner la chaine de correspondant au(x) departement(s) de la ville
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($nomDep);
    } catch (PDOException $ex) {    // traitemement des erreurs
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function getListeDepartementsFromIdRegion($idRegion) {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->prepare("select departement_id,departement_nom, departement_code from departements where departement_region_id = :idreg order by departement_nom;");
        $requete->bindParam(":idreg", $idRegion);
        $requete->execute() or die(print_r($requete->errorInfo()));

        $tabDept = array();

        while ($tab = $requete->fetch()) {
            /* à completer */
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabDept);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
