<?php

require_once '../inc/fonctions.inc.php';
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    $commande = $_GET['typeDemande'];
    switch ($commande) {
        case 'o':
            getListeOs();
            break;
        case 'v':
            $os = filter_input(INPUT_GET, 'os');
            getListeVersionsFromIdOs($os);
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}
