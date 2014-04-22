<?php
if (!empty($_POST["txtUserName"]) && !empty($_POST["txtpass"])) {

    $user = $_POST["txtUserName"];
    $prenom = $_POST["txtPrenom"];
    $nom = $_POST["txtNom"];
    $phone = $_POST["txtphone"];
    $pass = $_POST["txtpass"];

    // Vérifier si l'usager est dans le fichier Includes/users.txt
    $fichier = fopen("Includes/users.txt", "r");

    while ($ligne = fgets($fichier)) {
        $mot = explode(";", $ligne);

        if ($mot[0] == $user) {
            echo "Ce nom d'utilisateur est déjà utilisé.";
            fclose($fichier);
            return;
        } else {
            fclose($fichier);
            $fichier = fopen("Includes/users.txt", "a");
            fwrite($fichier, $user);
            fwrite($fichier, ";");
            fwrite($fichier, $pass);
            fwrite($fichier, ";");
            fwrite($fichier, $prenom);
            fwrite($fichier, ";");
            fwrite($fichier, $nom);
            fwrite($fichier, ";");
            fwrite($fichier, $phone);

            fwrite($fichier, "\r\n");
            echo "Utilisateur créé";
            fclose($fichier);
            return;
        }
    }
}
?>

<form id="form1" method="POST">
    <div class="span10">
        <h2>Pour vous créer une compte, remplir ce formulaire</h2>
        <p>
<!--            <div ID="MessageLiteral"></div>-->
        </p>
        <fieldset>
            <legend></legend>
            <table>
                <tr>
                    <td><span>Prenom: </span></td>
                    <td><input type="Text" name="txtPrenom"/></td>
                </tr>
                <tr>
                    <td><span>Nom: </span></td>
                    <td><input type="Text" name="txtNom"/></td>
                </tr>
                <tr>
                    <td><span># Mobile: </span></td>
                    <td><input type="Text" name="txtphone"/></td>
                </tr>
                <tr>
                    <td><span>Nom d'utilisateur : </td>
                    <td><input type="Text" name="txtUserName"/></td>
                </tr>
                <tr>
                    <td><span>Mot de passe : </span></td>
                    <td><input type="Text" name="txtpass"/></td>
                </tr>
            </table>   
            <input type="submit" name=="LogInButton" value="S'inscrire" />
        </fieldset>
    </div>
</form>

