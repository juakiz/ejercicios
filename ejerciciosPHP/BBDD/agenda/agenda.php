<?php
	require("funcionesBD.php");
	
	if (isset($_REQUEST["accion"])) {
		$accion = $_REQUEST["accion"];
		
		$servidor = "localhost";
		$usuario = "root";
		$clave = "";
		$baseDatos = "db_agenda";
		$conexion = new mysqli($servidor, $usuario, $clave, $baseDatos);
		if ($conexion->connect_error)
			die("Conexión fallida: ".$conexion->connect_error);

		
		if ($accion == "buscar") {
			$nombre = $_REQUEST['nombre'];
			$contactosEncontrados = buscarContactos($nombre);
			if (count($contactosEncontrados) == 0) {
				echo "<p class=\"error\">No se encuentra en la agenda el nombre indicado</p>";
			} else {
				mostrarContactos($contactosEncontrados);
			}
		}
		
		if ($accion == "anadir") {
			$nombre = $_REQUEST['nombre'];
			$telefono = $_REQUEST['telefono'];
			if ($nombre == "" || $telefono == "") { 
				echo "<p class=\"error\">Debe indicar el nombre y el teléfono del contacto a añadir</p>";
			} else {
				if (!is_numeric($telefono)) {
					echo "<p class=\"error\">Debe indicar un número de teléfono correcto para el contacto a añadir</p>";
				} else {
					anadirContacto($nombre, $telefono);
				}
			}
			$contactosEncontrados = buscarContactos("TODOS");
			mostrarContactos($contactosEncontrados);
		}
		
		if ($accion == "eliminar") {
			$nombre = $_REQUEST['nombre'];
			if ($nombre == "") { 
				echo "<p class=\"error\">Debe indicar el nombre del contacto a eliminar</p>";
			} else {
				eliminarContacto($nombre);
			}
			$contactosEncontrados = buscarContactos("TODOS");
			mostrarContactos($contactosEncontrados);
		}			
		
		if ($accion == "actualizar") {
			$nombre = $_REQUEST['nombre'];
			$telefono = $_REQUEST['telefono'];		
			if ($nombre == "" || $telefono == "") { 
				echo "<p class=\"error\">Debe indicar el nombre y el teléfono del contacto a actualizar</p>";
			} else {
				if (!is_numeric($telefono)) {
					echo "<p class=\"error\">Debe indicar un número de teléfono correcto para el contacto a actualizar</p>";
				} else {
					actualizarContacto($nombre, $telefono);
				}
			}
			$contactosEncontrados = buscarContactos("TODOS");
			mostrarContactos($contactosEncontrados);
		}

		if ($accion == "importar") {
			if (isset($_FILES['fichero'])) {
				$fichero = $_FILES['fichero'];
				$nombre = $fichero['name'];
				$tipo = $fichero['type'];
				$sobreescribir = $_REQUEST['sobreescribir'];
				if ($tipo != 'application/vnd.ms-excel') {
					echo "<p class=\"error\">Debe indicarfffff un archivo CSV de contactos</p>";
				} else {
					importarContactos($fichero, $sobreescribir);
				}
			} else {
				echo "<p class=\"error\">Debe indicarASAAASD un archivo CSV de contactos</p>";
			}
			$contactosEncontrados = buscarContactos("TODOS");
			mostrarContactos($contactosEncontrados);
		}

		$conexion->close();
	}
?>