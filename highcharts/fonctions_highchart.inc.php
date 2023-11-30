<?php


define("SERVEURBD", "172.18.58.7");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "diet");


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




function getConsommation($idUser) {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $tabSeries = array();
        // generation des tableaux des series et categories pour l'utilisateur
            $requete = $bdd->prepare("SELECT prenom, quantite , nomFruit "
                    . "from  consommation, fruits, users "
                    . "where fruits.idFruit=consommation.idFruit "
                    . "and users.idUser=consommation.idUser "
                    . "and consommation.idUser=:id order by fruits.idFruit; ");
            $requete->bindParam(":id", $idUser);
            $requete->execute();
            $tabSerieCourante = array();
            $tabCategorie = array();
            while ($ligne = $requete->fetch()) {
                array_push($tabSerieCourante, $ligne['quantite']);
                array_push($tabCategorie, $ligne['nomFruit']);
		    $prenom=$ligne['prenom'];
            }
            $requete->closeCursor();
            array_push($tabSeries,array(
                'name' => $prenom,
                'data' => $tabSerieCourante
            ));

        $tabDonnees= array(
            "series" => $tabSeries,
            "categories" => $tabCategorie            
            );
        return $tabDonnees;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function getConsommations() {
    try {
        // connexion à la base de données
        $bdd = connexionBdd();
        $tabUsers = getUsers(); // recuperation du tableau des users
        $tabSeries = array();
        // generation des tableaux des series et categories pour chaque user
        foreach ($tabUsers as $user) {
            $requete = $bdd->prepare("SELECT quantite , nomFruit "
                    . "from  consommation, fruits "
                    . "where fruits.idFruit=consommation.idFruit "
                    . "and consommation.idUser=:id order by fruits.idFruit; ");
            $requete->bindParam(":id", $user['idUser']);
            $requete->execute();
            $tabSerieCourante = array();
            $tabCategorie = array();
            while ($ligne = $requete->fetch()) {
                array_push($tabSerieCourante, $ligne['quantite']);
                array_push($tabCategorie, $ligne['nomFruit']);
            }
            $requete->closeCursor();
            array_push($tabSeries,array(
                'name' => $user['prenom'],
                'data' => $tabSerieCourante
            ));
        }
        $tabDonnees= array(
            "series" => $tabSeries,
            "categories" => $tabCategorie            
            );
        return $tabDonnees;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function getUsers() {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->query("SELECT idUser, prenom from users;");
        $tabPrenoms = array();
        while ($ligne = $requete->fetch()) {
            array_push($tabPrenoms, array(
                'prenom' => $ligne['prenom'],
                'idUser' => $ligne['idUser'],
                    )
            );
        }
        $requete->closeCursor();
        return $tabPrenoms;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}