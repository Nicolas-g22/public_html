<?php
require_once './fonctions_highchart.inc.php';
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'GET') {
    $action = filter_input(INPUT_GET, "action");
    switch ($action) {
        case 'getConsommation':
		$idu = filter_input(INPUT_GET, "idUser");
            $tabConso = getConsommation($idu);
            //envoyer les données au format json
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tabConso, JSON_NUMERIC_CHECK);
            break;
        case 'getConsommations':
            $tabConso = getConsommations();
            //envoyer les données au format json
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tabConso, JSON_NUMERIC_CHECK);
            break;
    }
}