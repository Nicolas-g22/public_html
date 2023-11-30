<?php

define("SERVEURBD", "195.221.61.190");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "exempleAjax");

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
 * @brief Retourne, au format json, l'adresse de la personne dont l'id est passée en parametre
 * @param type $id
 */
function getAdresse($id) {
    try {
        // connexion BD
        $bdd = connexionBdd();


        $requete = $bdd->prepare("select prenom from user where id = :idU ;");
        $requete->bindParam(":idU", $id);
        $requete->execute() or die(print_r($requete->errorInfo()));
        if ($requete->rowCount() == 0) {
            $adresse = "pas d'adresse";
        } else {
            $adresse = $requete->fetchColumn();
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($adresse);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

/**
 * @brief Retourne, sous forme de tableau json, la liste des personnes (id,nom) de la table user
 */
function getListeUsers() {
    try {
        // connexion BD
        $bdd = connexionBdd();
        $requete = $bdd->query("select id,nom from user order by nom;") or die(print_r($requete->errorInfo()));

        // creation du tableau
        $tabUsers = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : id et nom
            array_push($tabUsers, array('id' => $tab['id'], 'nom' => $tab['nom']));
        }
        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabUsers);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
