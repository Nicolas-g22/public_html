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

function getNomDepartementFromNumero($numeroDepartement) {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->prepare("SELECT departement_nom FROM departements WHERE departement_code like :nro ;");
        $requete->bindParam(":nro", $numeroDepartement);
        $requete->execute() or die(print_r($requete->errorInfo()));

        $nbLigne = $requete->rowCount();
        if ($nbLigne == 0) {
            $nomDep = "pas de departement correspondant";
        } else {
            $nomDep = "";
            while ($ligne = $requete->fetch()) {
                $nomDep = $nomDep . " " . $ligne['departement_nom'];
            }
        }
        $requete->closeCursor();
        // envoyer la réponse au format json
        header('Content-Type: application/json');
        echo json_encode($nomDep);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
