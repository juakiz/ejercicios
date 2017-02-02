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
	
	$usuario = $clave = $tipo = "";
		
	$conexion = new mysqli("localhost", "root", "", "db_notas_varias_asignaturas");
	if ($conexion->connect_error)
		die("Conexión fallida: ".$conexion->connect_error);			

	
	if ($accion == "listar" && isset($_REQUEST['Id'])) {
		$Id = $_REQUEST['Id'];
		$asignaturas = listarAsignaturas($profesor);
		if ($Id == "listarAsignaturas")
			$tamano = "font-size:20px;";
		else
			$tamano = "";
		echo "<select name=\"asignatura\" id=\"".$Id."\" class=\"tabla\" style=\"width:120px; ".$tamano."\" onChange=\"buscarAlumnos(this.value);\">";
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
	
	if ($accion == "buscar" && isset($_REQUEST['asignatura'])) {
		$asignatura = $_REQUEST['asignatura'];
		
		$arrayAlumnos = buscarAlumnos($asignatura);
		mostrarTablaAlumnos($arrayAlumnos);
	}
	
	if ($accion == "anadir" && isset($_REQUEST['asignatura'])) {
		$asignatura = $_REQUEST['asignatura'];
		
		if ($asignatura == "") {
			echo "<p class=\"titulo\" style=\"color:red; text-align:center;\">Debe indicar un nombre para la asignatura nueva</p>";
			$arrayAlumnos = buscarAlumnos($asignatura);
			mostrarTablaAlumnos($arrayAlumnos);
		} else {
			if (anadirAsignatura($asignatura, $profesor) == FALSE) {
				echo "<p class=\"titulo\" style=\"color:red; text-align:center;\">Ya existe una asignatura llamada ".$asignatura."</p>";
			}
			$arrayAlumnos = buscarAlumnos($asignatura);
			mostrarTablaAlumnos($arrayAlumnos);
		}
	}
	
	if ($accion == "eliminar" && isset($_REQUEST['asignatura'])) {
		$asignatura = $_REQUEST['asignatura'];
		
		eliminarAsignatura($asignatura);
	}

	if ($accion == "modificar" && isset($_REQUEST['alumno']) && isset($_REQUEST['asignatura']) && isset($_REQUEST['matriculado'])) {
		$alumno = $_REQUEST['alumno'];
		$asignatura = $_REQUEST['asignatura'];
		$matriculado = $_REQUEST['matriculado'];
		
		modificarMatricula($alumno, $asignatura, $matriculado);
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

	function mostrarTablaAlumnos ($arrayAlumnos) {
		echo "<span class=\"texto\">".count($arrayAlumnos)." alumnos encontrados"."</span>";
		echo "<br><br>";
		echo "<table class=\"tabla\" border=\"0\" cellpadding=\"7\">";
		echo "<tr>";
				echo "<th>Alumno</th>";		
				echo "<th>Matriculado</th>";
		echo "</tr>";
		for ($i = 0; $i < count($arrayAlumnos); $i++) {
			$alumno = $arrayAlumnos[$i]["alumno"];
			$matriculado = $arrayAlumnos[$i]["matriculado"];
			echo "<tr onMouseOver=\"filaMouseOver(this);\" onMouseOut=\"filaMouseOut(this);\">";
			echo "<td>";
				echo $alumno;
			echo "</td>";	
			echo "<td class=\"texto\">";
				if ($matriculado == true) {
					$seleccionado = "checked";
				} else {
					$seleccionado = "";
				}
				echo "<input type=\"checkbox\" style=\"color:rgb(100,0,0); width:20px; height:20px;\" name=\"\" id=\"\" value=\"".$alumno."\" ".$seleccionado." 
						onChange=\"modificarMatricula(this.value, document.getElementById('listarAsignaturas').value, this.checked);\">";
			echo "</td></tr>";
		}					
		echo "</table>";
	}	
	
	function buscarAlumnos ($asignatura) {
		global $conexion;		
		
		$arrayAlumnosAsignatura = array();
		$consultaSQL = "SELECT * 
							FROM t_notas 
							WHERE asignatura = '".$asignatura."';";						
		$resultado = $conexion->query($consultaSQL);
		
		if ($resultado->num_rows > 0) {
			$i = 0;
			while ($registro = $resultado->fetch_assoc()) {
				$arrayAlumnosAsignatura[$i] = $registro["alumno"];
				$i++;
			}
			$resultado->close();
		}
		
		$arrayTodosAlumnos = array();
		/*$consultaSQL = "SELECT * 
							FROM t_usuarios 
							LEFT JOIN t_notas ON usuario=alumno 
							WHERE tipo='Alumno' AND (asignatura='".$asignatura."' OR ISNULL(asignatura)) 
							ORDER BY usuario;";*/
		$consultaSQL = "SELECT * 
							FROM t_usuarios 
							WHERE tipo='Alumno' ORDER BY usuario;";
		$resultado = $conexion->query($consultaSQL);
		
		if ($resultado->num_rows > 0) {
			$i = 0;
			while ($registro = $resultado->fetch_assoc()) {
				$alumno = $registro["usuario"];
				$arrayTodosAlumnos[$i]["alumno"] = $alumno;
				if (in_array($alumno, $arrayAlumnosAsignatura))
					$arrayTodosAlumnos[$i]["matriculado"] = true;
				else
					$arrayTodosAlumnos[$i]["matriculado"] = false;
				$i++;
			}
			$resultado->close();
		}
		return $arrayTodosAlumnos;
	}
	
	function existeAsignatura ($asignatura) {
		global $conexion;
		$consultaSQL = "SELECT * 
						FROM t_asignaturas 
						WHERE asignatura = '".$asignatura."';";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows == 0)		// no existe la asignatura
			return false;
		else
			return true;
	}
	
	function anadirAsignatura ($asignatura, $profesor) {
		global $conexion;
		if (existeAsignatura($asignatura) == FALSE) {		// si no existe ya la asignatura
			$consultaSQL = "INSERT INTO t_asignaturas (asignatura, profesor) 
								VALUES ('".$asignatura."','".$profesor."');";
			if ($conexion->query($consultaSQL) === FALSE) {
				echo "Error: ".$conexion->error;
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	
	function eliminarAsignatura ($asignatura) {
		global $conexion;
		$consultaSQL = "DELETE FROM t_asignaturas 
							WHERE asignatura='".$asignatura."';";
		if ($conexion->query($consultaSQL) === FALSE) {
			echo "Error: ".$conexion->error;
		}
	}
	
	function modificarMatricula ($alumno, $asignatura, $matriculado) {
		global $conexion;
		if ($matriculado == "true")
			$consultaSQL = "INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('".$alumno."', '".$asignatura."', null);";
		if ($matriculado == "false")
			$consultaSQL = "DELETE FROM t_notas WHERE alumno = '".$alumno."' AND asignatura = '".$asignatura."';";
		if ($conexion->query($consultaSQL) === FALSE) {
			echo "Error: ".$conexion->error;
		}
	}
?>