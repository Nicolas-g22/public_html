<?php

require_once dirname(__FILE__) . '/config.inc.php';

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


function genererListeEntrepriseJson() {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->query("select id, nom from clients");
        $tab = array();
        while ($ligne = $requete->fetch()) {
            array_push($tab, array('id' => $ligne['id'], 'nom' => $ligne['nom']));
        }
        $requete->closeCursor();
        return $tab;
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function getDataTableauSpareClient() {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->query("select boites.id as idboit, boites.reference as bref, iots.reference as iref, spares.reference as sref, spares.nom_spare, clients.nom, sites.adresse,sites.cp, sites.ville
                                from boites,spares,iots,clients,client_sites,sites,boite_spare_clients
                                where clients.id=client_sites.id_client
                                and client_sites.id_site=sites.id
                                and sites.id=boite_spare_clients.id_site
                                and boites.id=boite_spare_clients.id_boite
                                and iots.id=boites.id_iot
                                and spares.id=boite_spare_clients.id_spare;");
        $tab = array();
        while ($ligne = $requete->fetch()) {
            array_push($tab, array(
                'DT_RowId' => $ligne['idboit'],
               /* A completer */
                "{$ligne['adresse']} {$ligne['cp']} {$ligne['ville']}",
                '<img src="img/supp.png" alt="" height="20"/><img src="img/modif.png" alt=""  height="20"/>'
            ));
        }
        $requete->closeCursor();
        return $tab;
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function genererListeBoiteJson(){
    try{
        $bdd = connexionBdd();
        $requete = $bdd->query("SELECT boites.id,boites.reference,spares.nom_spare,spares.reference 
                                FROM boites
                                INNER JOIN boite_spare_clients 
                                ON boites.id = boite_spare_clients.id_boite
                                INNER JOIN spares 
                                ON boite_spare_clients.id_spare = spares.id
                                WHERE id_site IS NULL AND id_iot IS NOT NULL;");
        $tab = array();
        while ($ligne = $requete->fetch()) {
            array_push($tab, array('boites.id' => $ligne['boites.id'], 'boites.reference' => $ligne['boites.reference'], 'spares.nom_spare' => $ligne['spares.nom_spare'], 'spares.reference' => $ligne['spares.reference']));
        }
        $requete->closeCursor();
        return $tab;
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function genererListeSiteFromIdEntreprise($idEn){
    try{
        $bdd = connexionBdd();
        $requete = $bdd->query("SELECT adresse, cp, ville FROM sites
                                INNER JOIN client_sites
                                ON sites.id = client_sites.id_site
                                WHERE client_sites.id_client = :idEn;");
        $requete->bindParam(":idEn", $idEn);
        $tab = array();
        while ($ligne = $requete->fetch()) {
            array_push($tab, array('adresse' => $ligne['adresse'], 'cp' => $ligne['cp'], 'ville' => $ligne['ville']));
        }
        $requete->closeCursor();
        return $tab;
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}