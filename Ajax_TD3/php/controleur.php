<?php

require_once './modele.inc.php';
// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
    switch ($commande) {
        case 'getDepartementsPourVille' :

            $nomVille = filter_input(INPUT_GET, 'ville');

            if ($nomVille != false) {
                getNomDepartementFromVille($nomVille);
            }
            break;
        case 'getRegions' :
           
            break;
        
        case 'getDepartementsRegions' :
            getListeDepartementsRegions();
            break;
        case 'getDepartementsPourNumero' :
          
            break;
        case 'getDepartements' :
            // récupération du numéro de département
            $idRegion = filter_input(INPUT_GET, 'idRegion', FILTER_VALIDATE_INT);
            // $numero est bien un entier
            if ($idRegion != false) {
                getListeDepartementsFromIdRegion($idRegion);
            }
            break;

        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}

