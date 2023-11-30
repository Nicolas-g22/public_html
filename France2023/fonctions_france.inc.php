<?php

define("SERVEURBD", "172.18.58.7");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "france2015");

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

function getNomDepartementFromVille($ville) {
    try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $requete = $bdd->prepare("SELECT departement_nom FROM villes,departements WHERE villes.ville_departement_id=departements.departement_id AND ville_nom LIKE :laville;");
// remplacement des variables de la requête par les valeurs effectives
        $requete->bindParam(":laville", $ville);
//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        if ($nbLigne == 0) {    // si pas de correspondance de nom de ville
            $nomDep = "pas de departement correspondant";
        }
        if ($nbLigne == 1) {    // si une seule correspondance de nom de ville
            $nomDep = $requete->fetchColumn(0);
        }
        if ($nbLigne > 1) { // si plusieurs correspondance de nom de ville
            $nomDep = "";
            while ($ligne = $requete->fetch()) {
                $nomDep = $nomDep . "<br/>" . $ligne['departement_nom'];
            }
        }
//libération des ressources de la requête
        $requete->closeCursor();
//retourner la chaine de correspondant au(x) departement(s) de la ville
        return $nomDep;
    } catch (PDOException $ex) {    // traitemement des erreurs
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function afficheRegions(){
    try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
        
// préparation de la requete paramétrée
        $requete = $bdd->query("SELECT region_nom FROM regions ORDER BY region_nom");

// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) { // si plusieurs correspondance de nom de ville
            $nomDep = "";
            while ($ligne = $requete->fetch()) {
                echo "{$ligne['region_nom']}</br>";
            }
        }
//libération des ressources de la requête
        $requete->closeCursor();

    } catch (PDOException $ex) {    // traitemement des erreurs
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function afficherDepartementsRegions(){
     try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
        
// préparation de la requete paramétrée
// préparation de la requete paramétrée
        $requete = $bdd->query("SELECT departement_nom, region_nom FROM departements INNER JOIN regions ON departements.departement_region_id = regions.regions_id ORDER BY region_nom;");
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) { // si plusieurs correspondance de nom de ville
            $nomDep = "";
            echo "<table>";
            echo "<tr><th>region</th><th>departement</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['region_nom']}</td> <td>{$ligne['departement_nom']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
//libération des ressources de la requête
        $requete->closeCursor();

    } catch (PDOException $ex) {    // traitemement des erreurs
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
   
    
}