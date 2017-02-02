<?php
	session_start();
	if (isset($_SESSION['usuario'])) {
		$usuario = $_SESSION['usuario'];
		if (isset($_SESSION['tipo'])) {
			$tipo = $_SESSION['tipo'];
			if ($tipo == "Alumno") {
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
	
	function obtenerNotas ($alumno) {
		global $conexion;
		$arrayNotas = array();
		$consultaSQL = "SELECT * FROM t_notas WHERE alumno = '".$alumno."' ORDER BY asignatura;";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows > 0) {
			while ($registro = $resultado->fetch_assoc()) {
				$arrayNotas[$registro["asignatura"]] = $registro["nota"];
			}
			$resultado->close();
		}
		return $arrayNotas;
	}
	
	function calcularEstadisticas ($asignatura) {
		global $conexion;
		$consultaSQL = "SELECT * FROM t_notas WHERE asignatura='".$asignatura."';";
		$res = $conexion->query($consultaSQL);
		$totalAlumnos = $res->num_rows;
		$res->close();
		$consultaSQL = "SELECT * FROM t_notas WHERE asignatura='".$asignatura."' AND nota >= 5;";
		$res = $conexion->query($consultaSQL);
		$aprobados = $res->num_rows;
		$res->close();
		$consultaSQL = "SELECT * FROM t_notas WHERE asignatura='".$asignatura."' AND nota < 5;";
		$res = $conexion->query($consultaSQL);
		$suspensos = $res->num_rows;
		$res->close();
		$resultado = array();
		$resultado['numeroAprobados'] = $aprobados;
		$resultado['numeroSuspensos'] = $suspensos;
		$resultado['numeroAlumnos'] = $totalAlumnos;
		$resultado['porcentajeAprobados'] = round($aprobados/$totalAlumnos*100)."%";
		$resultado['porcentajeSuspensos'] = round($suspensos/$totalAlumnos*100)."%";
		return $resultado;
	}
?> 

<html>
<head> 
	<title>Notas - Alumno</title> 
	<link rel="stylesheet" href="estilos.css">
</head> 
<body bgcolor="#11AAEE">
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
	
	<div id="divNotas" style="position:absolute; left:10px; top:220px; width:560px; height:250px; border:2px solid gray; background:#CCCCCC;">
		<?php
			$conexion = new mysqli("localhost", "root", "", "db_notas_varias_asignaturas");
			if ($conexion->connect_error)
				die("Conexión fallida: ".$conexion->connect_error);		
		
			$arrayNotas = obtenerNotas($usuario);
			
			$alturaDiv;
			if (count($arrayNotas) == 0) {
				$alturaDiv = 120;
			} else {
				$alturaDiv = 50+count($arrayNotas)*100;
			}
			echo "<script>";
			echo "document.getElementById('divNotas').style.height=".$alturaDiv.";";
			echo "</script>";
			if (count($arrayNotas) == 0) {
				echo "<br><p class=\"resaltado\" style=\"font-size:20px; text-align:center;\">No estás matriculado en ninguna asignatura aún</p>";
			} else {
				//echo "<br>";
				echo "<p class=\"resaltado\" style=\"font-size:18px;\">&nbsp;&nbsp;Asignaturas:</p>";
				echo "<ul style=\"list-style-type:square\">";
				foreach ($arrayNotas as $asignatura=>$nota) {
					echo "<li class=\"resaltado\">".$asignatura.": ";
						if ($nota == null) {
							$nota = "no tienes nota aún";
							echo "<span style=\"font-size:20px; text-align:center;\">".$nota."</span>";
						} else {
							if ($nota < 5) {
								$nota = "tu nota es ".$nota;
								echo "<span style=\"font-size:20px; color:red; text-align:center;\">".$nota."</span>";
							} else {
								$nota = "tu nota es ".$nota;
								echo "<span style=\"font-size:20px; color:green; text-align:center;\">".$nota."</span>";
							}
						}
						$estadisticas = calcularEstadisticas($asignatura);
						echo "<br><p class=\"texto\" style=\"text-align:center; font-weight:normal;\">Estadísticas: ".$estadisticas['numeroAprobados']." aprobados (".$estadisticas['porcentajeAprobados'].") y ".
						$estadisticas['numeroSuspensos']." suspensos (".$estadisticas['porcentajeSuspensos'].") de ".$estadisticas['numeroAlumnos']." alumnos</p>";
					echo "</li>";
					echo "<br>";
				}
				echo "</ul>";
			}
			$conexion->close();
		?>
	</div>

	<div name="menu" style="position:absolute; left:410px; top:15px; width:150px; height:65px; background:#DDDDDD; 
		border:2px solid gray; padding:5px; text-align:center; font-family:verdana; color:blue; font-size:14px;">
		<span class="titulo"> <?php echo $usuario; ?> </span>
		<hr>
		<button type="button" class="boton" onClick="window.location.assign('logout.php');" onMouseEnter="this.style.backgroundColor='#BBBBBB';" onMouseOut="this.style.backgroundColor='#22BBFF';">CERRAR SESIÓN</button>
	</div>
	
</body> 
</html>
