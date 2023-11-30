function getDepartementPourVille(event) {
    event.preventDefault();
    $("#tableauDepartementsVille").empty();
    $("#tableauDepartementsVille").append("<tr><th>Département</th></tr>");
    $.getJSON('php/controleur.php',
            {
                'commande': 'getDepartementsPourVille',
                'ville': $("#ville").val()
            }
    )
            .done(function (donnees, stat, xhr) {


                $.each(donnees, function (index, ligne) {
                    $("#tableauDepartementsVille").append("<tr><td>" + ligne + "</td></tr>");
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}
function getDepartementPourNumero(event)
{
    event.preventDefault();
    
}
function getListeRegions()
{
    $("#tableauRegions").empty(); // vider le tableau
    $("#tableauRegions").append("<tr><th>Régions</th></tr>");   // ajout en-tete tableau
    $.getJSON('php/controleur.php',
            {
                'commande': 'getRegions'
            }
    )
            .done(function (donnees, stat, xhr) {

                // génération contenu du tableau des régions
                $.each(donnees, function (index, ligne) {
                    $("#tableauRegions").append("<tr><td>" + ligne.nomRegion + "</td></tr>");
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });

}
function getListeDepartementsRegions()
{
    $("#tableauDepartementsRegions").empty();
    $("#tableauDepartementsRegions").append("<tr><th>Département</th><th>Régions</th></tr>");
   
}

function genererListeRegions() {
    $("#regions").empty();  // vider la liste des régions
    
}
function getListeDepartements()
{
    var idRegion = $(this).val(); // on récupère la valeur de la clef primaire correspondant à la région


    $("#tableauDepartements").empty();
    $("#tableauDepartements").append("<tr><th>Département</th></tr>");

    // si la region selectionné existe (pas le "choisissez une region")
    if (idRegion != -1) {
        $.getJSON('php/controleur.php',
                {
                    'commande': 'getDepartements',
                    'idRegion': idRegion
                }
        )
                .done(function (donnees, stat, xhr) {
                    // génération du contenu du tableau des départements
                    $.each(donnees, function (index, ligne) {
                        $("#tableauDepartements").append("<tr><td>" + ligne.nomDepartement + " ( " + ligne.code + " )</td></tr>");
                    });
                })
                .fail(function (xhr, text, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + text);
                    console.log("error : " + error);
                });
    }

}

$(document).ready(function ()
{
    // association evenement submit du formulaire formVilleDept avec l'appel de la fonction getDepartementPourVille
    $("#formVilleDept").submit(getDepartementPourVille);
    // association evenement click sur l'onglet tabRegions-tab  avec l'appel de la fonction getListeRegions
    $("#tabRegions-tab").click(getListeRegions);
    // association evenement click sur l'onglet tabDepartementRegion-tab  avec l'appel de la fonction getListeDepartementsRegions

    // association evenement submit du formulaire formNumDept avec l'appel de la fonction getDepartementPourNumero

    // générer la liste déroulante des régions
    genererListeRegions();
    // association evenement change de la liste regions avec l'appel de la fonction getListeDepartements



});
