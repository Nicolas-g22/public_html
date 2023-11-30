<?php

define("SERVEURBD", "195.221.61.190");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "france2015");

/**
 * @brief crée la connexion avec la base de donnée et retourne l'objet PDO pour manipuler la base
 * @return \PDO
 */
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

/**
 * @brief retourne l'ensemble des régions sous forme de tableau json
 */
function getListeRegions() {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->query("select * from regions order by region_nom;") or die(print_r($requete->errorInfo()));

        $tabRegion = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : idRegion, nomRegion
            array_push($tabRegion, array('idRegion' => $tab['regions_id'], 'nomRegion' => $tab['region_nom']));
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabRegion);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
/**
 * @brief retourne les départements, sous forme de tableau json, ayant pour région celle dont l'id est passé en paramètre
 * @param type $idRegion
 */
function getListeDepartementsFromIdRegion($idRegion) {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->prepare("select departement_id,departement_nom from departements where departement_region_id = :idreg order by departement_nom;");
        $requete->bindParam(":idreg", $idRegion);
        $requete->execute() or die(print_r($requete->errorInfo()));

        $tabDept = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : idDepartement, nomDepartement
            array_push($tabDept, array('idDepartement' => $tab['departement_id'], 'nomDepartement' => $tab['departement_nom']));
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

function getListeVillesFromIdDepartement($idDept) {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->prepare("select ville_id,ville_nom from villes where ville_departement_id = :idDept order by ville_nom;");
        $requete->bindParam(":idDept", $idDept);
        $requete->execute() or die(print_r($requete->errorInfo()));

        $tabVille = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : idDepartement, nomDepartement
            array_push($tabVille, array('idVille' => $tab['ville_id'], 'nomVille' => $tab['ville_nom']));
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabVille);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
