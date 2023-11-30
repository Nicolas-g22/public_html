<?php
require_once './fonctions.inc.php';
// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
    switch ($commande) {
        case 'getAdresse' :
            // récupération du numéro de département
            $id = filter_input(INPUT_GET, 'idUser',FILTER_VALIDATE_INT);
            // $numero est bien un entier
            if ($id!=false)
            {
                getAdresse($id);
            }
            break;
        case 'listeUser' :            
            getListeUsers();
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}

