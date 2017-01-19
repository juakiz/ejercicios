<?php
		function mostrarContactos ($arrayContactos) {
			echo "<table class=\"texto\" cellpadding=\"10\" border=\"1\" style=\"border-collapse:collapse;\" width=\"450\">";
				echo "<tr><th>Nombre</th><th>Teléfono</th></tr>";
				foreach ($arrayContactos as $nombre=>$telefono) {
					echo "<tr><td width=\"100\">".$nombre."</td><td width=\"100\">".$telefono."</td></tr>";
				}
			echo "</table>";
			echo "<p class=\"texto\">".count($arrayContactos)." contactos encontrados en la agenda</p>";
		}	
	
		function existeContacto ($nombre) {
			global $conexion;
			$consultaSQL = "SELECT * FROM t_contactos WHERE nombre = '".$nombre."';";
			$resultado = $conexion->query($consultaSQL);
			if ($resultado->num_rows > 0)
				return true;
			else	
				return false;
		}
		
		function buscarContactos ($nombre) {
			global $conexion;
			$contactosEncontrados = array();
			if ($nombre == "" || $nombre == "TODOS")
				$consultaSQL = "SELECT * FROM t_contactos;";
			else
				$consultaSQL = "SELECT * FROM t_contactos WHERE nombre LIKE '".$nombre."%';";
			
			if ($resultado = $conexion->query($consultaSQL)) {
				if ($resultado->num_rows > 0) {
					while ($registro = $resultado->fetch_assoc()) {
						$contactosEncontrados[$registro["nombre"]] = $registro["telefono"];
					}
				}
				$resultado->close();
			}
			return $contactosEncontrados;
		}
	
		function anadirContacto ($nombre, $telefono) {
			global $conexion;
			if (existeContacto($nombre)) {
				echo "<p class=\"error\">Ya existe en la agenda el nombre indicado</p>";
			} else {
				$consultaSQL = "INSERT INTO t_contactos (nombre, telefono) VALUES ('".$nombre."',".$telefono.");";
				if ($conexion->query($consultaSQL) === TRUE) {
					echo "<p class=\"ok\">Contacto añadido correctamente a la agenda</p>";
				} else {
					echo "<p class=\"error\">".$conexion->error."</p>";
				}
			}
		}
		
		function eliminarContacto($nombre) {
			global $conexion;
			$consultaSQL = "DELETE FROM t_contactos WHERE nombre='".$nombre."';";
			if (existeContacto($nombre)) {
				if ($conexion->query($consultaSQL) === TRUE) {
					echo "<p class=\"ok\">Contacto eliminado correctamente de la agenda</p>";
				} else {
					echo "<p class=\"error\">".$conexion->error."</p>";
				}
			} else {
				echo "<p class=\"error\">No existe en la agenda el nombre indicado</p>";
			}
		}

		function actualizarContacto ($nombre, $telefono) {
			global $conexion;
			if (!existeContacto($nombre)) {
				echo "<p class=\"error\">No existe en la agenda el nombre del contacto indicado</p>";
			} else {
				$consultaSQL = "UPDATE t_contactos SET telefono=".$telefono." WHERE nombre='".$nombre."';";
				if ($conexion->query($consultaSQL) === TRUE) {
					echo "<p class=\"ok\">Contacto actualizado correctamente en la agenda</p>";
				} else {
					echo "<p class=\"error\">".$conexion->error."</p>";
				}
			}
		}
		
		function importarContactos ($fichero, $sobreescribir) {
			global $conexion;
			// Copia el archivo temporal a la carpeta de destino
			$rutaDef = "./";
			if (!is_dir($rutaDef))
				mkdir($rutaDef);
			$nombreTmp = $fichero['tmp_name'];
			$nombreDef = $rutaDef . $fichero['name'];
			$resultado = copy($nombreTmp,$nombreDef);
			if ($resultado == 0)
				unlink($nombreTmp); // Borra el archivo temporal
					
			if ($sobreescribir == "true") {
				// Borra todos los registros de la tabla:
				$consultaSQL = "DELETE FROM t_contactos;";
				$conexion->query($consultaSQL);
			}
					
			$ficheroCSV = fopen ($nombreDef, "r");
			while (!feof($ficheroCSV)) {
				$contacto = fgets($ficheroCSV);
				if ($contacto != "") {
					$valores = explode(";", $contacto);
					$nombre = $valores[0];
					$telefono = $valores[1];
					$consultaSQL = "INSERT INTO t_contactos (nombre, telefono) VALUES ('".$nombre."',".$telefono.");";
					$conexion->query($consultaSQL);
				}
			}
			fclose($ficheroCSV);
					
			//unlink($nombreDef);	// borra el archivo CSV subido
			
			echo "<p class=\"ok\">Contactos importados correctamente a la agenda</p>";
		}
?>