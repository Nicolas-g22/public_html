<!DOCTYPE html>
<html>
    <head>
        <title>Formulaire ville -> département</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
            require_once './fonctions_france.inc.php';
            $nomVille = $_POST['ville'];
            // version avec filter_input:
            // $nomVille = filter_input(INPUT_POST,'ville');
            $nomDepartement=getNomDepartementFromVille($nomVille);
            echo "<div>";
            echo "ville de <b>$nomVille</b> se trouve dans le département : <br/>";
            echo "<b>$nomDepartement</b>";
            echo "</div>";
        ?>
    </body>
</html>
