<?php
if (!empty($_POST["txtUserName"]) && !empty($_POST["txtpass"])) {

    $user = $_POST["txtUserName"];
    $pass = $_POST["txtpass"];

    // Vérifier si l'usager est dans le fichier Includes/users.txt
    $fichier = fopen("Includes/users.txt", "r");
    while ($ligne = fgets($fichier)) {
        $mot = explode(";", $ligne);

        if ($mot[0] == $user && $mot[1] == $pass) {
            if (isset($_SESSION["user1"])) {
                echo "La session est déjà ouverte";
                echo "<a href=" . "index.php?page=sortir" . "> Click </a> Fermer la session";
                return;
            } else {
                $_SESSION["user1"] = $user;
                fclose($fichier);
                header("Location:index.php?page=users");
            }
        }
    }
    echo "le user n'est pas trouvé";
    fclose($fichier);
}
?>
<!--<div style='margin: 0px auto; height: 300px; width: 400px'>-->
    <form id="ajax-contact-form" action="">
        <div class="span10">
            <h2 class="title"><span>Entrez votre informations d'authentification</span></h2>

            <p><div ID="MessageLiteral"></div></p>
            <fieldset>
                <div>
                    <span>Nom d'utilisateur : </span>
                    <input class="span3" type="Text" name="txtUserName"/>
                </div>
                <div>
                    <span>Mot de passe : </span>
                    <input class="span3" type="Text" name="txtpass"/>
                </div>
                <div>
                    <span> Se souvenir de moi? </span>
                    <input type="checkbox" name="remembermeCheckBox" />
                </div>
                <input type="submit" name=="LogInButton" value="Se connecter" />
            </fieldset>
            <p>
                <a href="index.php?page=registrer"> S'inscrire </a>
                ici si vous n'avez pas compte d'utilisateur.
            </p>
        </div>
    </form>
<!--</div>-->







