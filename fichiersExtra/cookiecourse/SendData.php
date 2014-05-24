<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<base target="top_right">
<link href="Languaje.css" rel="stylesheet" type="text/css">
<title>Send Data / Envia Datos</title>
<meta http-equiv="imagetoolbar" content="false">
<META NAME="Title" CONTENT="Cookie Test  CookieObjects Class">
<META NAME="Author" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Keywords" CONTENT="Cookie, PHP5, Class">
<META NAME="Language" CONTENT="Español/English">
<META NAME="Copyright" CONTENT="© Chavero Soft">
<META NAME="Designer" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Publisher" CONTENT="Guillermo de Jesus Perez Chavero">
<META NAME="Robots" CONTENT="Index">
<style type="text/css">
<!--
.style3 {font-size: 9px}
-->
</style>
</head>
<body class="Normal">
<div align="center">
  <h1>Cookie Test  CookieObjects Class</h1>
</div>
<p align="center"><label class="Spanish">Español</label> / <label class="English">English</label></p>
<p><label class="Spanish">Definimos un tipo de objeto</label> / <label class="English">Define a type of object</label>:
<label class="Spanish">Objeto de cosina</label> / <label class="English">Kitchen object</label>. </p>

<ul>
	<label class="Spanish">Los Objetos</label> / <label class="English">The Objects</label>:
		<li><label class="Spanish">Taza</label> / <label class="English">Cup</label>: Color, <label class="Spanish">Tamaño</label> / <label class="English"> size</label>, <label class="Spanish">Tipo</label> / <label class="English">Type</label></li>
		<li><label class="Spanish">Plato</label> / <label class="English">plate</label>: Color, <label class="Spanish">Tamaño</label> / <label class="English">size</label>, <label class="Spanish">Tipo</label> / <label class="English">Type</label></li>
		<li><label class="Spanish">Cuchara</label> / <label class="English">spoon</label>: Color, <label class="Spanish">Tamaño</label> / <label class="English">size</label>, <label class="Spanish">Tipo</label> / <label class="English">Type</label></li>
</ul>

	<label class="Spanish">Las acciones</label> / <label class="English">The actions</label>:
<hr />
<form action="GetData.php?Action=Add" method="post">
<table border="0" cellspacing="0" cellpadding="2" summary="" align="center">
 <tr>
  <td class="Normal"><label class="Spanish">Objeto</label> / <label class="English"> Object</label>:</td>
  <td>
	<select name="Obj" class="Normal" >
		<option value="Taza / Cup">Taza / Cup</option>
		<option value="Plato / Plate">Plato / plate</option>
		<option value="Cuchara / Spoon">Cuchara / spoon</option>
	</select>
	</td>
 </tr>
 <tr>
  <td class="Normal">Color:</td>
  <td><input type="text" name="Color" class="Normal" /></td>
 </tr>
 <tr>
  <td class="Normal"><label class="Spanish">Tamaño</label> / <label class="English"> size</label>:</td>
  <td><input type="text" name="Size" class="Normal" /></td>
 </tr>
 <tr>
  <td class="Normal"><label class="Spanish">Tipo</label> / <label class="English">Type</label></td>
  <td><input type="text" name="Type" class="Normal" /></td>
 </tr>
 <tr>
  <td colspan="2" align="right"><button type="submit" class="Normal">Añadir / Add</button></td>
 </tr>
</table>
</form>
<hr />
<form action="GetData.php?Action=Remove" method="post">
<table border="0" cellspacing="0" cellpadding="2" summary="" align="center">
 <tr>
  <td class="Normal"><input type="radio" name="rb" value="O" class="Normal"  checked><label class="Spanish">Objeto</label> / <label class="English"> Object</label>:</td>
  <td>
	<select name="Obj" class="Normal" >
		<option value="Taza / Cup">Taza / Cup</option>
		<option value="Plato / Plate">Plato / plate</option>
		<option value="Cuchara / Spoon">Cuchara / spoon</option>
	</select>
	</td>
 </tr>
 <tr>
  <td class="Normal"><input type="radio" name="rb" value="C" class="Normal">Color:</td>
  <td><input type="text" name="Color" class="Normal" /></td>
 </tr>
 <tr>
  <td class="Normal"><input type="radio" name="rb" value="S" class="Normal"><label class="Spanish">Tamaño</label> / <label class="English"> size</label>:</td>
  <td><input type="text" name="Size" class="Normal" /></td>
 </tr>
 <tr>
  <td class="Normal"><input type="radio" name="rb" value="T" class="Normal"><label class="Spanish">Tipo</label> / <label class="English">Type</label></td>
  <td><input type="text" name="Type" class="Normal" /></td>
 </tr>
 <tr>
  <td colspan="2" align="right"><button type="submit" class="Normal" >Remover / Remove</button></td>
 </tr>
</table>
</form>
<hr />
<form action="GetData.php?Action=RemoveCookie" method="post">
<button type="submit" class="Normal" >Remover Cookie / Remove Cookie</button>
</form>
<div align="right"><span class="style3"><a href="mailto:chavero81@yahoo.es">Copyright 2004
  </a></span>
</div>
</body>
</html>
