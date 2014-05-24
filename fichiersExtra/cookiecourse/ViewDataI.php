<?php
	require_once('CookieObjects.php');
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
<title>View Data I</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="Normal">
<p align="center"><label class="Spanish">Datos cargados desde la cookies.</label> / <label class="English">Data loaded from cookie.</label></p>
<?php

	$cookie_k = new CookieObjects("cookie_kitchen","Any - Doesn't matter");
	if ($cookie_k->Exist()) {
	 		$cookie_k->ReadCookie();
			$cookie_k->ParseCookie();
			if ($cookie_k->CountObjects()>0) {
				$Width = 96/$cookie_k->CountItems();
				echo '<table summary="" cellpadding="0" cellspacing="1" align="center"'.
					 'title="" width="500" border="0" bgcolor="black">'.
					 '<td bgcolor="silver" colspan="5" align="center" class="normal"><label class="Spanish">Objeto de cosina</label> / <label class="English">Kitchen object</label></td>'.
					 '<tr>'.
					 '<td>'.
					  '<table summary="Heder" cellpadding="0" cellspacing="0" width="100%" border="0" bgcolor="silver">'.
					 '<tr bgcolor="silver" align="center" class="normal">'.
					 '	<td width="'.$Width.'%"><label class="Spanish">Objetos</label> / <label class="English">Objects</label></td>'.
					 '	<td width="'.$Width.'%">Color</td>'.
					 '	<td width="'.$Width.'%"><label class="Spanish">Tamaño</label> / <label class="English"> size</label></td>'.
					 '	<td width="'.$Width.'%"><label class="Spanish">Tipo</label> / <label class="English">Type</label></td>'.
					 '<td width="4%" >&nbsp;</td>'.
					 '</tr>'.
					 '</table>'.
					 '<div style="height:150px; overflow: auto;">'. 
				 	 '<table summary="Content" cellpadding="0" cellspacing="0" width="100%" border="1">';
				$Width = 100/$cookie_k->CountItems();
				for ($i = 0; $i<$cookie_k->CountObjects(); $i++) {
					echo '<tr bgcolor="#FFFFFF" class="normal" align="center" >';
					for ($j = 0; $j<$cookie_k->CountItems() ; $j++) {
						echo '<td width="'.$Width.'%">'.$cookie_k->PData[$i][$j].'</td>';
					}
					echo '</tr>';
				}
				echo '</table></div>'.
					 '</td>'.
				 	 '</tr>'.
				 	 '</table>';
				}
			else{
		 		echo "<p align='center'><label class='Spanish'>La cookie existe, pero no tiene objetos</label> / <label class='English'>The cookie exist, but it hasn't objects</label>. </p>";
			}
	}
	else {
		 echo "<p align='center'><label class='Spanish'>La cookie no existe.</label> / <label class='English'>The cookie doesn't exist.</label>. </p>";
	
	}
?>
<p align="center"><button type="button" onclick="window.open('ViewDataI.php','','location=0,status=0,scrollbars=0,width=550,height=275');" class="Normal">PopUp</button></p>
</body>
</html>
