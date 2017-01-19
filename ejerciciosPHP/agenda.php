<html>
<head><title>Agenda de contactos</title>
<style>
	.titulo {color:#000088; font-family:verdana; font-size:18px; font-weight:bold;}
	.texto {color:#000088; font-family:verdana; font-size:14px;}
</style>
</head>
<body bgcolor="#11AAEE">
<p class="titulo">Base de Datos de contactos:</p>
<form method="post" action="" class="texto">
	<table>
		<tr> <td>Nombre:</td>
		<td colspan="2"><input type="text" name="nombre" size="20" maxlength="20"></td>
		</tr>
		<tr> <td>Teléfono:</td>
		<td colspan="2"><input type="number" name="telefono" size="20"></td>
		</tr>
		<tr height="10"></tr>
		<tr> <td><input type="submit" name="buscar" value="BUSCAR"></td>
		<td><input type="submit" name="anadir" value="AÑADIR"></td>
		<td><input type="submit" name="eliminar" value="ELIMINAR"></td>
		<td><input type="submit" name="actualizar" value="ACTUALIZAR"></td>
		</tr>
		<tr><td></td><td></td><td></td>
		<td><input type="submit" name="importar" value="IMPORTAR"></td>
		</tr>
	</table>
</form>
<br><hr align="left" width="270">
<?php
function existeContacto ($nombre) {
	global $conexion;
	$consultaSQL = "SELECT * FROM t_contactos WHERE nombre = '".$nombre."';";
	$resultado = $conexion->query($consultaSQL);
	if ($resultado->num_rows > 0) return true;
	else return false;
}
function buscarContacto ($nombre) { // muestra una tabla con los contactos encontrados
	global $conexion;
	if ($nombre == "")
		$consultaSQL = "SELECT * FROM t_contactos;";
	else
		$consultaSQL = "SELECT * FROM t_contactos WHERE nombre LIKE '".$nombre."%';";
	$encontrados = 0;
	if ($resultado = $conexion->query($consultaSQL)) {
		if ($resultado->num_rows > 0) {
			echo "<table class=\"texto\" cellpadding=\"10\" border=\"1\" style=\"border-collapse:collapse;\"><tr><th>Nombre</th><th>Teléfono</th></tr>";
			while ($registro = $resultado->fetch_assoc()) {
				echo "<tr><td width=\"100\">".$registro["nombre"]."</td><td width=\"100\">".$registro["telefono"]."</td></tr>";
			}
			echo "</table>";
			echo "<p class=\"texto\">".$resultado->num_rows." contactos encontrados en la agenda</p>";
			$encontrados = $resultado->num_rows;
		}
		$resultado->close();
	}
	return $encontrados;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$servidor = "localhost"; $usuario = "root"; $clave = ""; $baseDatos = "db_agenda";
	$conexion = new mysqli($servidor, $usuario, $clave, $baseDatos);
	if ($conexion->connect_error)
		die("Conexión fallida: ".$conexion->connect_error);
	if (isset($_POST['buscar'])) {
		$nombre = $_POST['nombre'];
		if (buscarContacto($nombre) == 0)
			echo "<p style=\"color:red;\">No se encuentra en la agenda el nombre indicado</p>";
	}
	if (isset($_POST['anadir'])) {
		$nombre = $_POST['nombre']; $telefono = $_POST['telefono'];
		if ($nombre == "" || $telefono == "") {
			echo "<p style=\"color:red;\">Indique el nombre y el teléfono del contacto a añadir</p>";
			buscarContacto("");
		} else {
			if (existeContacto($nombre)) {
				echo "<p style=\"color:red;\">Ya existe en la agenda el nombre indicado</p>";
			} else {
				$consultaSQL = "INSERT INTO t_contactos (nombre, telefono) VALUES ('".$nombre."',".$telefono.");";
				if ($conexion->query($consultaSQL) === TRUE)
					echo "<p style=\"color:green;\">Contacto añadido correctamente a la agenda</p>";
				else
					echo "<p style=\"color:red;\">".$conexion->error."</p>";
			}
			buscarContacto("");
		}
	}
	if (isset($_POST['eliminar'])) {
		$nombre = $_POST['nombre'];
		if ($nombre == "") {
			echo "<p style=\"color:red;\">Debe indicar el nombre del contacto a eliminar</p>";
			buscarContacto("");
		} else {
			$consultaSQL = "DELETE FROM t_contactos WHERE nombre='".$nombre."';";
			if (existeContacto($nombre)) {
				if ($conexion->query($consultaSQL) === TRUE) {
					echo "<p style=\"color:green;\">Contacto eliminado de la agenda</p>";
				} else {
					echo "<p style=\"color:red;\">".$conexion->error."</p>";
				}
			} else {
				echo "<p style=\"color:red;\">No existe en la agenda el nombre indicado</p>";
			}
			buscarContacto("");
		}
	}
	$conexion->close();
}
?>
</body>
</html>