<?php
    if (empty($_POST["txtUsername"]) || empty($_POST["txtPassword"]) || empty($_POST["txtFirstname"]) || empty($_POST["txtLastname"]) || empty($_POST["txtPhone"])) {
        echo "<div style='color:red;'>Certain champs sont manquant! Assurez vous que tous les champs sont bien remplis.</div>";
    }
    else {
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
        
        if ($mySqli->query("SELECT * FROM Customers WHERE Username = '" . $_POST["txtUsername"] . "'")->num_rows > 0) {
            echo "<div style='color:red;'>Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.</div>";
        }
        else {
            $mySqli->query("INSERT INTO Customers (Username, Password, Firstname, Lastname, Phone) VALUES ('" .
                    $_POST["txtUsername"] .  "', '" .
                    $_POST["txtPassword"] .  "', '" .
                    $_POST["txtFirstname"] . "', '" .
                    $_POST["txtLastname"] .  "', '" .
                    $_POST["txtPhone"] .     "')");
            if ($mySqli->affected_rows == 1) {
                setcookie("username", $_POST["txtUsername"], $SECONDS_IN_A_DAY * 90);
                echo "<div style='color:green;'>Votre compte a été créé avec succès! Vous serez redirigez vers la page d'accueil dans 5 secondes.</div>";
                header("refresh:5;url=index.php" );
            }
            else {
                echo "<div style='color:red;'>Une erreur s'est produite: " . $mySqli->error . ".</div>";
            }
        }
    }
?>