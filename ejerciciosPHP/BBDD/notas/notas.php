<?php
	session_start();
	if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
		$tipo = $_SESSION['tipo'];
		if ($tipo == "Profesor") {
			$profesor = $_SESSION['usuario'];
		} else {
			header("Location: login.php");
		}
	} else {
		header("Location: login.php");
	}

	if (isset($_REQUEST['accion']))
		$accion = $_REQUEST['accion'];
	else
		exit;
	
	$alumno = $nota = "";
		
	$conexion = new mysqli("localhost", "root", "", "db_notas_varias_asignaturas");
	if ($conexion->connect_error)
		die("Conexión fallida: ".$conexion->connect_error);			

	
	if ($accion == "listar") {
		$asignaturas = listarAsignaturas($profesor);
		echo "<select name=\"asignatura\" id=\"asignatura\" class=\"tabla\" style=\"width:140px; font-size:20px;\" onChange=\"buscarAlumnos(this.value);\">";
			for ($i=0; $i < count($asignaturas); $i++) {
				$asignatura = $asignaturas[$i];
				if ($i == 0)
					$seleccionado = "selected";
				else
					$seleccionado = "";
				echo "<option value=\"".$asignatura."\" ".$seleccionado.">".$asignatura."</option>";
			}
		echo "</select>";
	}
	
	if ($accion == "buscar" && isset($_REQUEST['asignatura']) && isset($_REQUEST['nota'])) {
		$nota = $_REQUEST['nota'];
		$asignatura = $_REQUEST['asignatura'];
		$arrayAlumnos = buscarAlumnos($asignatura, $nota);
		mostrarTablaAlumnos($asignatura, $arrayAlumnos);
	}
	
	if ($accion == "modificar" && isset($_REQUEST['alumno']) && isset($_REQUEST['asignatura']) && isset($_REQUEST['nota']) && isset($_REQUEST['listar'])) {
		$alumno = $_REQUEST['alumno'];
		$nota = $_REQUEST['nota'];
		$asignatura = $_REQUEST['asignatura'];
		$listar = $_REQUEST['listar'];
		modificarNota($alumno, $asignatura, $nota);
		$arrayAlumnos = buscarAlumnos($asignatura, $listar);
		mostrarTablaAlumnos($asignatura, $arrayAlumnos);	
	}
	
	$conexion->close();
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function listarAsignaturas ($profesor) {
		global $conexion;
		$arrayAsignaturas = array();
		$consultaSQL = "SELECT * FROM t_asignaturas WHERE profesor='".$profesor."' ORDER BY asignatura;";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows > 0) {
			while ($registro = $resultado->fetch_assoc()) {
				array_push($arrayAsignaturas, $registro["asignatura"]);
			}
			$resultado->close();
		}
		return $arrayAsignaturas;
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
		$resultadoArray = array();
		$resultadoArray['numeroAprobados'] = $aprobados;
		$resultadoArray['numeroSuspensos'] = $suspensos;
		$resultadoArray['numeroAlumnos'] = $totalAlumnos;
		if ($totalAlumnos == 0) {
			$resultadoArray['porcentajeAprobados'] = "0%";
			$resultadoArray['porcentajeSuspensos'] = "0%";
		} else {
			$resultadoArray['porcentajeAprobados'] = round($aprobados/$totalAlumnos*100)."%";
			$resultadoArray['porcentajeSuspensos'] = round($suspensos/$totalAlumnos*100)."%";
		}
		return $resultadoArray;
	}
	
	function mostrarTablaAlumnos ($asignatura, $arrayAlumnos) {		
		echo "<span class=\"texto\">".count($arrayAlumnos)." alumnos encontrados</span><br>";
		$estadisticas = calcularEstadisticas($asignatura);
		echo "<span class=\"texto\">Estadísticas: ".$estadisticas['numeroAprobados']." alumnos aprobados (".$estadisticas['porcentajeAprobados'].") y ".
			$estadisticas['numeroSuspensos']." suspensos (".$estadisticas['porcentajeSuspensos'].") de ".$estadisticas['numeroAlumnos']."</span>";		
		echo "<br><br>";
		echo "<table class=\"tabla\" border=\"0\" cellpadding=\"6\">";
		echo "<tr>";
				echo "<th>Alumno</th>";
				echo "<th>Nota</th>";
		echo "</tr>";
		for ($i = 0; $i < count($arrayAlumnos); $i++) {
			$alumno = $arrayAlumnos[$i]["alumno"];
			$nota = $arrayAlumnos[$i]["nota"];
			echo "<tr onMouseOver=\"filaMouseOver(this);\" onMouseOut=\"filaMouseOut(this);\">";
			echo "<td>";					
				echo $alumno;
			echo "</td>";
			echo "<td>";
				echo "<select class=\"tabla\" style=\"width:90px; font-size:16px;\" onChange=\"modificarNota('".$alumno."','".$asignatura."',this.value);\">";
					echo "<option value=\"nulo\">-</option>";
					for ($j=1; $j<=10; $j++) {
						if ($j == $nota)
							$seleccionado = "selected";
						else
							$seleccionado = "";
						echo "<option value=\"".$j."\" ".$seleccionado.">".$j."</option>";
					}
				echo "</select>";
			echo "</td></tr>";
		}					
		echo "</table>";
	}	
	
	function buscarAlumnos ($asignatura, $nota) {
		global $conexion;
		$arrayAlumnos = array();
		switch ($nota) {
			case "TODOS":
				$condicion = "";
				break;
			case "aprobados":
				$condicion =  "AND nota >= 5";
				break;
			case "suspensos":
				$condicion =  "AND nota < 5";
				break;
		}
		$consultaSQL = "SELECT * FROM t_notas WHERE asignatura='".$asignatura."'" .$condicion." ORDER BY alumno;";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows > 0) {
			$i = 0;
			while ($registro = $resultado->fetch_assoc()) {
				$arrayAlumnos[$i]["alumno"] = $registro["alumno"];
				$arrayAlumnos[$i]["nota"] = $registro["nota"];
				$i++;
			}
			$resultado->close();
		}
		return $arrayAlumnos;
	}
	
	function modificarNota ($alumno, $asignatura, $nota) {
		global $conexion;
		$consultaSQL = "UPDATE t_notas SET nota=".$nota." WHERE alumno='".$alumno."' AND asignatura='".$asignatura."';";
		if ($conexion->query($consultaSQL) === FALSE) {
			echo "Error: ".$conexion->error;
		}
	}
	
?>