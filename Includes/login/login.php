<?php
    if (!empty($_SESSION["TryRegisterResult"])) {
        switch($_SESSION["TryRegisterResult"]) {
            case "MissingInfos":
                echo "<div style='color:red;'>Certain champs sont manquant! Assurez vous que tous les champs sont bien remplis.</div>";
                break;
            case "Erreur":
                echo "<div style='color:red; margin-left:15%;'>Nom d'utilisateur ou Mot de Passe Incorrect</div>";
                break;
            case "Success":
                echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
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
    else{
                echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
?>