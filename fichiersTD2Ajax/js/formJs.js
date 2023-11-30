

$(document).ready(function ()
{
    genererListeOs();

    // gestion liste deroulante
    $("#os").change(genererListeVersions);

});
