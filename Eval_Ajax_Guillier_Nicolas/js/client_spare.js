/* client_spare.js */

function remplirTableauBoiteClient() {
    $("#ent").find('option').not(':first').remove();
    $.getJSON('php/controleur.php',
            
            {
                "commande": "getBoitesSite"
                
            })
            .done(function (donnees, stat, xhr) {
                
                $('#tab_spare_client').DataTable({
                    /* a completer */
                    "lengthMenu": [[5, 10, 15, 25, 50, 100, -1], [5, 10, 15, 25, 50, 100, "Tous"]],
                    "pageLength": 5,
                    "language": {
                        "lengthMenu": "Afficher _MENU_ lignes par page",
                        "info": "page _PAGE_ sur _PAGES_",
                        "infoEmpty": "pas de résultat",
                        "search": "Recherchez: ",
                        "paginate": {
                            "first": "Premier",
                            "last": "Dernier",
                            "next": "Suivant",
                            "previous": "Précédent"
                        }
                    },
                    "order": [[5, "asc"]]
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function remplirListeSite()
{
    var idClient = $(this).val();
    $("#ent").find('option').not(':first').remove();
    
    $.getJSON('php/controleur.php',
            {
               
                "commande" : "getListeSites",
                "id" : "1"
            })
            .done(function (donnees, stat, xhr) {
               
                .done(function (donnees, stat, xhr) {
                $.each(donnees, function (index, ligne) {
                    //remplissage de la liste deroulante
                    $("#ent").append($('<option>', ligne.adresse, ligne.cp, ligne.ville));
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function remplirListeBoitesDisponibles()
{
    $("#ent").find('option').not(':first').remove();
    $.getJSON('php/controleur.php',
            {
                "commande" : "getListeBoites"
            })
            .done(function (donnees, stat, xhr) {
                $.each(donnees, function (index, ligne) {
                    //remplissage de la liste deroulante
                    $("#ent").append($('<option>', ligne.boites.id, ligne.boites.reference, ligne.spares.nom_spare, ligne.spares.reference));

            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function remplirListeEntreprises()
{
    $("#ent").find('option').not(':first').remove();    // vider la liste des entreprises sauf la 1ere ligne
    $.getJSON('php/controleur.php',
            {
                'commande': 'getListeClients'
            })
            .done(function (donnees, stat, xhr) {
                $.each(donnees, function (index, ligne) {
                    //remplissage de la liste deroulante des entreprises (#ent)
                    $("#ent").append($('<option>', {value: ligne.id}).text(ligne.nom));
                }
                );

            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

// ce qui est lance/implemtente a la fin du chargement de la page
$(document).ready(function () {


    remplirTableauBoiteClient();
    remplirListeEntreprises();
    remplirListeBoitesDisponibles();
    $("#ent").change(remplirListeSite);

});
