/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

/* global AjouterVersions */





function verifMDP(){
    // Recuperation du mot de passe
    var MDP = $("#mdp").val();
    
    // Recuperation de la confirmation du mot de passe
    var confirmMDP = $("#confirmation").val();
    
    $("#confirmation").next("p").remove();
    
    
    //afichage du msg d'erreur si differents
    if (MDP !== confirmMDP){
        alert("Les mots de passe ne sont pas identiques!");
        $("<p styles='position:absolute ; top:70px ; left:530px ; color:red'>Mot de passe différent</p>");
    }
    
}


function AjouterVersion(){
    //Recupération du choix liste OS
    var choixOS = $(this).val();
    
    //Effacement liste version pour choisir un autre OS
    $("#version").empty();
    
    switch (choixOS){
        case"WIN":
            $("#version").append($("<option>", {value: "seven"}), text("Seven"));
            $("#version").append($("<option>", {value: "win10"}), text("Windows 10"));
            $("#version").append($("<option>", {value: "win11"}), text("Windows 11"));
            $("#version").append($("<option>", {value: "winserveur"}), text("Windows Serveur"));
            break;
        
        
    }
}


$(document).ready(function(){
    $("#inscription").click(verifMDP);
    $("#se").change(AjouterVersions);
});