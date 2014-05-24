<?php
	require_once('CookieObjects.php');
	switch ($_GET['Action']){
		case "Add":
				$cookie_k = new CookieObjects("cookie_kitchen",'MyTypeofObject');
				if ($cookie_k->Exist()) {
					 	$cookie_k->ReadCookie();
						$cookie_k->ParseCookie();
				}
				$cookie_k->NewObject();
				$cookie_k->AddItem($_POST['Obj']);
				$cookie_k->AddItem($_POST['Color']);
				$cookie_k->AddItem($_POST['Size']);
				$cookie_k->AddItem($_POST['Type']);
				if (!$cookie_k->CreateCookie(true)) { echo "<p><font color='#ff0000'>Error - CreateCookie(true). :*(... </font></p>";}
				break;
		case "Remove":
				$cookie_k = new CookieObjects("cookie_kitchen",'MyTypeofObject');
				if ($cookie_k->Exist()) {
					 	$cookie_k->ReadCookie();
						$cookie_k->ParseCookie();
						switch($_POST['rb']){
							case "O";
								$Index = 0;
								$Value = $_POST['Obj'];
								break;
							case "C";
								$Index = 1;
								$Value = $_POST['Color'];
								break;
							case "S";
								$Index = 2;
								$Value = $_POST['Size'];
								break;
							case "T";
								$Index = 3;
								$Value = $_POST['Type'];
								break;
						};
						$cookie_k->DeleteObject ( $Index, $Value );
						if (!$cookie_k->CreateCookie(true)) { echo "<p><font color='#ff0000'>Error - CreateCookie(true). :*(... </font></p>";}
				}
				 break;
		case "RemoveCookie":
				$cookie_k = new CookieObjects("cookie_kitchen",'MyTypeofObject');
				if ($cookie_k->Exist()) $cookie_k->RemoveCookie();
				break;
		default:
				 break;
	};
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="Languaje.css" rel="stylesheet" type="text/css">
<meta http-equiv="imagetoolbar" content="false">
<META NAME="Title" CONTENT="Cookie Test  CookieObjects Class">
<META NAME="Author" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Keywords" CONTENT="Cookie, PHP5, Class">
<META NAME="Language" CONTENT="Español/English">
<META NAME="Copyright" CONTENT="© Chavero Soft">
<META NAME="Designer" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Publisher" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Robots" CONTENT="Index">
<title>Get Data</title>
</head>
<body class="Normal">
<p><label class="Spanish">Accion:</label> / <label class="English">Action: </label>
<?php 
	switch ($_GET['Action']){
		case "Add":
				echo "<label class='Spanish'>Añadir objeto</label> / <label class='English'>Add object</label>. </p>";
				break;
		case "Remove":
				echo "<label class='Spanish'>Remover objeto</label> / <label class='English'>Remove object</label>. </p>";
				echo "<label class='Spanish'>Indice </label> / <label class='English'>Index</label>: ".$Index."<br>";
				echo "<label class='Spanish'>Valor </label> / <label class='English'>Value</label>: ".$Value."<br>";
				echo "Objeto: ".$_POST['Obj']."<br>";
				echo "Color: ".$_POST['Color']."<br>";
				echo "Size: ".$_POST['Size']."<br>";
				echo "Type: ".$_POST['Type']."<br>";
				echo "Seleccion: ".$_POST['rb']."<br>";
				break;
		case "RemoveCookie":
				echo "<label class='Spanish'>Remover Cookie</label> / <label class='English'>Remove Cookie</label>. </p>";
				break;
		default:
				 echo "<label class='Spanish'>Ninguno</label> / <label class='English'>None.</label>. </p>";
				 break;
	};
	if (isset($cookie_k)) {
		 echo "<hr />";
		 echo "<label class='Spanish'>Datos en la cookie</label> / <label class='English'>Cookie Data</label>: ";
		 echo $cookie_k;
		 echo "<hr />";
		 echo "<br><label class='Spanish'>Objetos</label> / <label class='English'>Objects</label>: ".$cookie_k->CountObjects();
		 echo "<br><label class='Spanish'>Items por cada Objeto</label> / <label class='English'>Items for each Objects</label>: ".$cookie_k->CountItems();
		 echo "<br><br>".$cookie_k->Version();
	}
	else {
		 echo "<p align='center'><label class='Spanish'>La cookie no existe.</label> / <label class='English'>The cookie doesn't exist.</label>. </p>";
	}
?>

<script language=JavaScript type=text/javascript>
//<!--
	parent.bottom_right.location = "ViewDataI.php";
//-->
</script>
</body>
</html>
