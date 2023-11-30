<?php

require_once dirname(__FILE__) . '/fonctions_tibco.inc.php';


// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
    switch ($commande) {        
        case 'getListeClients' :

            $clients = genererListeEntrepriseJson();


            header('Content-Type: application/json');
            echo json_encode($clients);

            break;
        
        case 'getListeBoites':
            
            $boites = genererListeBoiteJson();
            
            header('Content-Type:  application/json');
            echo json_encode($boites);
        
        case 'getListeSites':
            $idEn = filter_input(INPUT_GET, 'id_client', FILTER_VALIDATE_INT);
            $sites = genererListeSiteFromIdEntreprise($idEn);
            
            header('Content-Type:  application/json');
            echo json_encode($sites);
            
        case 'getDataTableauSpareClient' :

            $listeEn = getDataTableauSpareClient();


            header('Content-Type: application/json');
            echo json_encode($listeEn);

            break;
            
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}

