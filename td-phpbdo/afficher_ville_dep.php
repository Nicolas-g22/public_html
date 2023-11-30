<style>
    table,td,th{
        border: 1px blue ridge;
        border-collapse: collapse;
        
    }
</style>
<?php
require_once './fonctions_france.inc.php';
$cp = $_POST['cp'];
afficherVillesFromCp($cp);
