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
function afficherPersonne(){
     try {
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
        
// préparation de la requete paramétrée
// préparation de la requete paramétrée
        $requete = $bdd->query("SELECT nom, prenom, dateNaissance, ville_nom, ville_code_postal, departement_nom, region_nom FROM utilisateurs INNER JOIN villes ON utilisateurs.ville_id=villes.ville_id INNER JOIN departements ON villes.ville_departement_id=departements.departement_id INNER JOIN regions ON departements.departement_region_id=regions.regions_id;");
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<table>";
            echo "<tr><th>nom</th><th>prenom</th><th>dateNaissance</th><th>ville_nom</th><th>ville_code_postal</th><th>departement_nom</th><th>region_nom</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['nom']}</td> <td>{$ligne['prenom']}</td> <td>{$ligne['dateNaissance']}</td> <td>{$ligne['ville_nom']}</td> <td>{$ligne['ville_code_postal']}</td> <td>{$ligne['departement_nom']}</td> <td>{$ligne['region_nom']}</td>";
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


function afficherVillesFromCp($cp) {
    try {
        
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
        $cpo="%$cp%";
// préparation de la requete paramétrée
        $requete = $bdd->prepare("SELECT ville_nom FROM villes WHERE ville_code_postal LIKE :cp;");
        
        $requete->bindParam(":cp", $cpo);
//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<table>";
            echo "<tr><th>ville_nom</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['ville_nom']}</td>";
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





function afficherCompteVillesFromCp($cp) {
    try {
        
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
        $cpo="%$cp%";
// préparation de la requete paramétrée
        $requete = $bdd->prepare("SELECT COUNT(ville_nom) as nb_villes FROM villes WHERE ville_code_postal LIKE :cp;");
        
        $requete->bindParam(":cp", $cpo);
//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<table>";
            echo "<tr><th>nb_villes</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['nb_villes']}</td>";
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

function afficherNombreCommuneParDepartement() {
    try {
        
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $requete = $bdd->prepare("SELECT COUNT(ville_departement), departement_nom FROM villes INNER JOIN departements ON villes.ville_departement_id = departements.departement_id GROUP BY ville_departement;");

//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<table>";
            echo "<tr><th>Nb Communes</th><th>Departements</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['COUNT(ville_departement)']}</td><td>{$ligne['departement_nom']}</td>";
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



function afficherNomDate() {
    try {
        
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $bdd->query("SET lc_time_names = 'fr_FR';");
        $requete = $bdd->prepare("SELECT nom, DATE_FORMAT(dateNaissance,'%D %W %M') FROM utilisateurs;");

//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<table>";
            echo "<tr><th>Nom</th><th>Date de naissance</th></tr> ";
            while ($ligne = $requete->fetch()){
                echo "<tr>";
                echo "<td>{$ligne['nom']}</td><td>{$ligne["DATE_FORMAT(dateNaissance,'%D %W %M')"]}</td>";
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

function genererListePersonne() {
    try {
        
// connexion au serveur de base de données et sélection de la base de données
        $bdd = connexionBdd();
// préparation de la requete paramétrée
        $bdd->query("SET lc_time_names = 'fr_FR';");
        $requete = $bdd->prepare("SELECT nom, DATE_FORMAT(dateNaissance,'%D %W %M') FROM utilisateurs;");

//execution de la requête
        $requete->execute();
// récupération du nombre de ligne retourné par la requête
        $nbLigne = $requete->rowCount();
        
        if ($nbLigne >= 1) {
            
            echo "<select name='personne'>";  
            while ($ligne = $requete->fetch()){
                echo "<option value>";
                echo "<td>{$ligne['nom']}</td><td>{$ligne["DATE_FORMAT(dateNaissance,'%D %W %M')"]}</td>";
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