function verifierAuthentification()
{
    // appel du script verifLogin.php via ajax
        $.ajax({          
            url: 'php/controleur.php',
            data: {
                "commande" : 'verifLogMdp',
                "login" : $("#login").val(),
                "mdp" : $("#mdp").val()
            }, 
            type: 'POST',
            dataType: 'json',
            success: // si la requete fonctionne, mise à jour de la couleur de pastille
                    function(donnees,status,xhr) {
                         $("#pastille").removeClass();
                        switch (donnees){                            
                            case 'v': $("#pastille").toggleClass("pastilleVerte"); break;
                            case 'r': $("#pastille").toggleClass("pastilleRouge"); break;
                            case 'o': $("#pastille").toggleClass("pastilleOrange"); break;
                        }                
                    },
            error:
                    function (xhr, status, error) {
                        console.log("param : " + JSON.stringify(xhr));
                        console.log("status : " + status);
                        console.log("error : " + error);

                    }
        });
}

$(document).ready(function ()
{
    // gestion du click sur le bouton d'authentification
    $("#verifLogin").click(verifierAuthentification);
});
