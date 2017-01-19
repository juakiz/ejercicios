<?php
	session_start();
	
	if (isset($_SESSION['usuario'])) {
		$usuario = $_SESSION['usuario'];
		if (isset($_SESSION['tipo'])) {
			$tipo = $_SESSION['tipo'];
			if ($tipo == "Profesor") {
				$horaInicio = $_SESSION['horainicio'];		
			} else {
				header("Location: login.php");
			}
		} else {
			header("Location: login.php");
		}
	} else {
		header("Location: login.php");
	}
?> 

<html>
<head> 
	<title>Notas - Profesor	</title> 
	<link rel="stylesheet" href="estilos.css">	
	<script>
		function botonMouseEnter (boton) {
			boton.style.backgroundColor = '#44CCFF';
		}

		function botonMouseOut (boton) {
			boton.style.backgroundColor = '#22BBFF';
		}
	</script>
</head> 
<body bgcolor="#11AAEE" onLoad="document.getElementById('contenido').src = 'usuarios.html';">
	<br>
	<table>
		<tr>
			<td><img src="imagenes/logo.png" width="128" height="128"></td>
			<td>
				<p class="principal">Has iniciado sesión como:</p>
				<table cellpadding="5">
					<tr><td class="titulo">Usuario:</td> <td class="texto"><?php echo $usuario; ?></td></tr>
					<tr><td class="titulo">Tipo:</td> <td class="texto"><?php echo $tipo; ?></td></tr>
					<tr><td class="titulo">Hora inicio sesión:</td> <td class="texto"><?php echo $horaInicio; ?></td></tr>
				</table>	
			</td>
		</tr>
	</table>
	
	<br>
	<hr align="left" width="560">
	<br>
	
	<div name="menu" style="position:absolute; left:410px; top:15px; width:150px; height:130px; background:#DDDDDD; 
		border:2px solid gray; padding:5px; text-align:center; font-family:verdana; color:blue; font-size:14px;">
		<span class="titulo"> <?php echo $usuario; ?> </span>
		<hr>
		<button type="button" class="boton" style="color:rgb(180,0,0);" onClick="window.location.assign('logout.php');" onMouseEnter="botonMouseEnter(this);" onMouseOut="botonMouseOut(this);">CERRAR SESIÓN</button>
		<br>
		<button type="button" class="boton" onClick="document.getElementById('contenido').src = 'usuarios.html';" onMouseEnter="botonMouseEnter(this);" onMouseOut="botonMouseOut(this);">USUARIOS</button>
		<br>
		<button type="button" class="boton" onClick="document.getElementById('contenido').src = 'notas.html';" onMouseEnter="botonMouseEnter(this);" onMouseOut="botonMouseOut(this);">NOTAS</button>
	</div>
	
	<iframe id="contenido" src="" width="560" height="430" style="border:2px solid gray;"></iframe>
	
</body> 
</html>

