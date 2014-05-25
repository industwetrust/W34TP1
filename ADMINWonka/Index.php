<?php
session_start();
if (isset($_SESSION["login"]))
	session_destroy();


if (isset($_POST["txtNom"]) && isset($_POST["txtPW"])) {
	$DB_HOST = "localhost";
	$DB_USER = "root";
	$DB_PASS = "";
	$DB_NAME = "tpw34";
	$mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

	$query = "SELECT nom FROM Admins WHERE User = " .
			" '" . md5($_POST["txtNom"]) . "' AND Password = '" . md5($_POST["txtPW"]) . "'";

	$result = $mySqli->query($query);

	if ($result->num_rows == 1) {
		//L'usager est Trouvé
		$ligne = $result->fetch_assoc();
		$_SESSION["nom"] = $ligne["nom"];
		header("Location: ../index.php");
	} else {
		"nope.";
	}
}
?>

<html>
    <head>
        <style></style>
    </head>
    <body>        
        <form method="POST" action="#">
            <table>
                <tr>
                    <td>Nom</td>
                    <td><input name="txtNom" type="text" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input name="txtPW" type="password" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="submit" />
                    </td>
                </tr>                
            </table>
        </form>
    </body>
</html>

