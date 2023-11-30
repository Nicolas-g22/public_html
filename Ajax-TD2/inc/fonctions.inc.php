<?php
require_once 'config.inc.php';
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

function getListeOs() {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->prepare("SELECT * FROM systeme order by nomSystème"
                . "");
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
  
