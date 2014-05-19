<?php
    if (!empty($_SESSION["TryRegisterResult"])) {
        switch($_SESSION["TryRegisterResult"]) {
            case "MissingInfos":
                echo "<div style='color:red;'>Certain champs sont manquant! Assurez vous que tous les champs sont bien remplis.</div>";
                break;
            case "UsernameTaken":
                echo "<div style='color:red;'>Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.</div>";
                break;
            case "Success":
                echo "<div style='color:green;'>Votre compte a été créé avec succès! Vous serez redirigez vers la page d'accueil dans 5 secondes.</div>";
                echo '<script language="Javascript">
<!--
document.location.replace("../index.php");
// -->
</script>';
                break;
            case "OtherSqlError":
                echo "<div style='color:red;'>Une erreur s'est produite: " . $mySqli->error . ".</div>";
                break;
            default:
                echo "<div style='color:red;'>Une erreur inconnue s'est produite.</div>";
                break;
        }
        
        unset($_SESSION["TryRegisterResult"]);
    }
?>