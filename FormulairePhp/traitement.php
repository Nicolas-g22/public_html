<?php

echo '<pre>';
print_r($_POST);
echo '</pre>';

echo 'Nom : ' . filter_input(INPUT_POST, "nom") . '</br>';
echo 'Prenom : ' . filter_input(INPUT_POST, "prenom") . '</br>';
echo 'Ville : ' . filter_input(INPUT_POST, "ville") . '</br>';
echo 'Mail : ' . filter_input(INPUT_POST, "email") . '</br>';
echo 'Site : ' . filter_input(INPUT_POST, "site") . '</br>';
echo 'Sexe : ' . filter_input(INPUT_POST, "sexe") . '</br>';
echo 'Photo : ' . filter_input(INPUT_POST, "photo") . '</br>';
echo 'Systeme d exploitation : ' . filter_input(INPUT_POST, "se") . '</br>';
echo 'Version : ' . filter_input(INPUT_POST, "version") . '</br>';
echo 'Java : ' . filter_input(INPUT_POST, "java") . '</br>';
echo 'C : ' . filter_input(INPUT_POST, "c") . '</br>';
echo 'PHP : ' . filter_input(INPUT_POST, "PHP") . '</br>';
echo 'Autre : ' . filter_input(INPUT_POST, "autre") . '</br>';
echo 'Login : ' . filter_input(INPUT_POST, "login") . '</br>';
echo 'Mdp : ' . filter_input(INPUT_POST, "mdp") . '</br>';
echo 'Confirmation Mdp : ' . filter_input(INPUT_POST, "cmdp") . '</br>';


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

