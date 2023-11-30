<?php
require_once './fonctions_france.inc.php';
// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
    switch ($commande) {
        case 'nomDeptFromNum' :
            //récupération du numéro de département
            $numero = filter_input(INPUT_GET, 'numeroDepartement');
            getNomDepartementFromNumero($numero);
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}
