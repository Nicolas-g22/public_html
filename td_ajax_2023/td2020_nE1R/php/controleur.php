<?php
require_once './fonctions.inc.php';
// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_POST, 'commande');
    switch ($commande) {
        case 'verifLogMdp' :
            // récupération du numéro de département
            $log = filter_input(INPUT_POST, 'login');
            $mdp = filter_input(INPUT_POST, 'mdp');
            verifierLogin($log, $mdp);
            
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}


