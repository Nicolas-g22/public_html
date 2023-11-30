var lat = 48.852969;
var lon = 2.349903;
var maCarte = null;
var marqueur;
var marqueurDyna;
var cercle;
var polygone;
var groupe = new L.featureGroup();

function initCarte() {
    maCarte = L.map('carte').setView([lat, lon], 11);
    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 19
    }).addTo(maCarte);
    console.log("initCarte");

}


// pour avoir les coordonnées en latitude,longitude d'une adresse, 
// nous utiliserons le site https://adresse.data.gouv.fr/api
// la fonction recherche les coordonnées en latitude,longitude
// à partir d'une adresse et place un marqueur avec comme 
// legende l'adresse
function ajouterMarqueur(adresse)
{        
    console.log(adresse);
    console.log(encodeURI(adresse));
    $.getJSON("https://api-adresse.data.gouv.fr/search/?q=" + adresse + "&limit=1")
            .done(function (resultat, status, xhr) {
                console.log(resultat.features[0].properties.city);
                var lonlat = resultat.features[0].geometry.coordinates;
                console.log(lonlat);
                marqueurDyna = L.marker([lonlat[1], lonlat[0]]).addTo(maCarte);
                marqueurDyna.bindPopup(resultat.features[0].properties.label);
                groupe.addLayer(marqueurDyna);
                maCarte.fitBounds(groupe.getBounds());

            })
            .fail(function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            });



}

function afficherMarqueurs()
{
    ajouterMarqueur("place des jacobins, 72000, le mans");
}
// affichage de la carte au chargement de la page
// via l'appel à la fonction initCarte
$(window).on('load', initCarte);


$(document).ready(function () {
    // au click sur l'élément ayant pour id "geoCode", faire appel à la fonction geolocalisation
    $("#geoCode").click(afficherMarqueurs);
});

