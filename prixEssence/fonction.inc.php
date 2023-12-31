<?php

require_once("config.inc.php");

function connexionBD() {
    try {
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE,
                LOGIN, MOTDEPASSE);
    } catch (Exception $ex) {
        die('<br />Pb connexion serveur BD : ' . $ex->getMessage());
    }
    return $bdd;
}

function obtenirValeur() {
    $bdd = connexionBD();
    $requete = $bdd->prepare("SELECT * FROM `prixEssence`;");
    $requete->execute() or die(print_r($requete->errorInfo()));
    $valeurs = array();
    $prix = array();
    while ($ligne = $requete->fetch()) {
        $prix["gazoil"] = floatval($ligne['gazoil']);
        $prix["super95"] = floatval($ligne['super95']);
        $prix["super98"] = floatval($ligne['super98']);
        $prix["brent"] = floatval($ligne['brent']);
        $valeurs[$ligne['annee']] = $prix;
    }
    echo json_encode($valeurs, JSON_FORCE_OBJECT);
}

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
obtenirValeur();
?>