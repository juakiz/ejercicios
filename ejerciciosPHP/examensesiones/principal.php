<?php
session_start();
if (isset($_SESSION['nombre'])){
	$nombre = $_SESSION['nombre'];

	if(isset($_POST['idioma']))
		$_SESSION['idioma'] = $_POST['idioma'];
	$idioma = $_SESSION['idioma'];

	if(isset($_POST['tamano']))
		$_SESSION['tamanyo'] = $_POST['tamano'];

	$tamanyo = $_SESSION['tamanyo'];
	$mantener = $_SESSION['mantener'];
	$hora = $_SESSION['hora'];
	//echo ">>".$idioma;
	if($idioma == "espanol"){
		$Iusuario = "Usuario";
		$Iidioma = "Idioma";
		$Itamanyo = "Tamanyo fuente";
		$Imantener = "Mantener Abierto";
		$Ihora = "Hora";
	}else{
		$Iusuario = "User";
		$Iidioma = "Languaje";
		$Itamanyo = "Font size";
		$Imantener = "Keep open";
		$Ihora = "Time";
	}

} else {
	header("Location: logout.php");
}
?>
<html>
<head>
<title>Principal</title>
		<style>
			.principal { font-family: arial; font-size: 20px; color: #0022DD; font-weight: bold; }
			.titulo { font-family: verdana; font-size: <?php echo $tamanyo; ?>px; color: #0000DD; }
			.boton { height: 30px; width: 140px; border-radius:2px 2px 2px 2px; border:1px solid #00DDEE; background: #7777FF; font-family: Arial; font-size: 12px; color: #FFF; }
		</style>
</head>
<body bgcolor="#EEEEEE">
<form name="login" method="post" action="">
	<table width="300" border="0" cellpadding="3" cellspacing="4">
		<tr>
			<td class="titulo"><?php echo $Iusuario; ?></td><td><?php echo $nombre; ?> </td>
		</tr>
		<tr>
			<td class="titulo"><?php echo $Iidioma; ?></td><td><?php echo $idioma; ?> </td>
			<td><select name="idioma" class="boton">
					<option value="espanol"> Español </option>
					<option value="ingles"> Inglés </option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="titulo"><?php echo $Itamanyo; ?></td><td><?php echo $tamanyo; ?> </td>
			<td><select name="tamano" class="boton">
					<option value="12"> 12 pixels </option>
					<option value="16"> 16 pixels </option>
					<option value="20"> 20 pixels </option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="titulo"><?php echo $Imantener; ?></td><td><?php echo $mantener; ?> </td>
		</tr>
		<tr>
			<td class="titulo"><?php echo $Ihora; ?></td><td><?php echo $hora; ?> </td>
		</tr>
		<tr align="center"><td colspan="2"><input class="boton" name="acceder" type="submit" value="CAMBIAR"></td></tr>
	</table>
</form>
<a href="./logout.php">LOG OUT</a>
</body>
</html>