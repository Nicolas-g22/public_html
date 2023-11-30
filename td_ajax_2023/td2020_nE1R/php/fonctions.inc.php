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
 * @brief vérifie la présence du couple login/mot de passe dans la base de données et retourne r ou v selon les cas de figure
 * @param type $log
 * @param type $mdp
 */
function verifierLogin($log, $mdp) {
    try {
        $bdd = connexionBdd();
// recherche du couple login/mdp dans la table user
        $requete = $bdd->prepare("select mdp from ;");
        $requete->bindParam(":log", $log);
        $requete->bindParam(":mdp", $mdp);
        $requete->execute() or die(print_r($requete->errorInfo()));
// comptage du nombre de resultats
        $nbLigne = $requete->rowCount();
        $requete->closeCursor();

        if ($nbLigne == 0) {// le couple login/mdp n'est pas présent dans la table user
            // il faudra retourner 'r'
            $retour = 'r';
            
        if ($log == 0 && $mdp == 1) {// le mdp n'est pas présent dans la table user
            //il faudra retourner 'o'
            $retour = 'o';
        }    
            
        } else {   // le couple login/mdp est présent dans la table user
            // il faudra retourner 'v'
            $retour = 'v';
        }
//on previent qu'on repond en json
        header('Content-Type: application/json;charset=utf-8');
        // envoyer les données au format json
        echo json_encode($retour);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
