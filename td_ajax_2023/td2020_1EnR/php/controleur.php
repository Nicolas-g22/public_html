<?php

require_once './fonctions.inc.php';
// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
    switch ($commande) {
        case 'getRegions' :
            getListeRegions();
            break;
        case 'getDepartements' :
            // récupération du numéro de département
            $idRegion = filter_input(INPUT_GET, 'idRegion', FILTER_VALIDATE_INT);
            // $numero est bien un entier
            if ($idRegion != false) {
                getListeDepartementsFromIdRegion($idRegion);
            }
            break;
        case 'getVilles' :
            // récupération du numéro de département
            $idDept = filter_input(INPUT_GET, 'idDepartement', FILTER_VALIDATE_INT);
            // $numero est bien un entier
            if ($idDept != false) {
                getListeVillesFromIdDepartement($idDept);
            }
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}



