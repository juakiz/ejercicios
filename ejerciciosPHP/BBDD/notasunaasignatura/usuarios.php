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
		
	$conexion = new mysqli("localhost", "root", "", "db_notas");
	if ($conexion->connect_error)
		die("Conexión fallida: ".$conexion->connect_error);			

	
	if ($accion == "buscar" && isset($_REQUEST['tipo'])) {
		$tipo = $_REQUEST['tipo'];
		$arrayUsuarios = buscarUsuarios($tipo);
		mostrarTablaUsuarios($arrayUsuarios);
	}
	
	if ($accion == "anadir" && isset($_REQUEST['usuario']) && isset($_REQUEST['clave']) && isset($_REQUEST['tipo']) && isset($_REQUEST['tipoListar'])) {
		$usuario = $_REQUEST['usuario'];
		$clave = $_REQUEST['clave'];
		$tipo = $_REQUEST['tipo'];
		$tipoListar = $_REQUEST['tipoListar'];
		
		if ($usuario == "" || $clave == "") {
			echo "<p class=\"titulo\" style=\"color:red; text-align:center;\">Debe indicar un nombre de usuario y una clave</p>";
			$arrayUsuarios = buscarUsuarios($tipoListar);
			mostrarTablaUsuarios($arrayUsuarios);
		} else {
			if (anadirUsuario($usuario, $clave, $tipo) == false) 
				echo "<p class=\"titulo\" style=\"color:red; text-align:center;\">Ya existe un usuario llamado ".$usuario."</p>";
			$arrayUsuarios = buscarUsuarios($tipoListar);
			mostrarTablaUsuarios($arrayUsuarios);
		}
	}
	
	if ($accion == "eliminar" && isset($_REQUEST['usuario']) && isset($_REQUEST['tipo'])) {
		$usuario = $_REQUEST['usuario'];
		$tipo = $_REQUEST['tipo'];
		
		eliminarUsuario($usuario);
		$arrayUsuarios = buscarUsuarios($tipo);
		mostrarTablaUsuarios($arrayUsuarios);
	}
	
	$conexion->close();
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function mostrarTablaUsuarios ($arrayUsuarios) {
		echo "<span class=\"texto\">".count($arrayUsuarios)." usuarios encontrados"."</span>";
		echo "<br><br>";
		echo "<table class=\"tabla\" border=\"0\" cellpadding=\"7\">";
		echo "<tr>";
				echo "<th>Usuario</th>";
				echo "<th>Tipo</th>";
				echo "<th></th>";
		echo "</tr>";
		for ($i = 0; $i < count($arrayUsuarios); $i++) {
			$usuario = $arrayUsuarios[$i]["usuario"];
			$tipo = $arrayUsuarios[$i]["tipo"];
			echo "<tr onMouseOver=\"this.style.backgroundColor='#22BBFF';\" onMouseOut=\"this.style.backgroundColor='#CCCCCC';\">";
			echo "<td>";
				echo $usuario;
			echo "</td><td>";
				echo $tipo;
			echo "</td><td>";
				echo "<img src=\"imagenes/eliminar.png\" width=\"16\" height=\"16\" onClick=\"eliminarUsuario('".$usuario."');\" onMouseEnter=\"this.style.backgroundColor='#EEEEEE';\" onMouseOut=\"this.style.backgroundColor='#CCCCCC';\">";
			echo "</td></tr>";
		}					
		echo "</table>";
	}	
	
	function buscarUsuarios ($tipo) {
		global $conexion;		
		$arrayUsuarios = array();
		if ($tipo == "TODOS")
			$condicion = "";
		else
			$condicion =  "WHERE tipo = '".$tipo."'";
		$consultaSQL = "SELECT * FROM t_usuarios ".$condicion." ORDER BY tipo, usuario;";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows > 0) {
			$i = 0;
			while ($registro = $resultado->fetch_assoc()) {
				$arrayUsuarios[$i]["usuario"] = $registro["usuario"];
				$arrayUsuarios[$i]["tipo"] = $registro["tipo"];
				$i++;
			}
			$resultado->close();
		}
		return $arrayUsuarios;
	}
	
	function existeUsuario ($usuario) {
		global $conexion;
		$consultaSQL = "SELECT * FROM t_usuarios WHERE usuario = '".$usuario."';";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows == 0)		// no existe ya el usuario
			return false;
		else
			return true;
	}
	
	function anadirUsuario ($usuario, $clave, $tipo) {
		global $conexion;
		if (existeUsuario($usuario) == FALSE) {		// si no existe ya el usuario
			$consultaSQL = "INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('".$usuario."','".$clave."','".$tipo."');";
			if ($conexion->query($consultaSQL) === FALSE) {
				echo "Error: ".$conexion->error;
				return false;
			} else {
				if ($tipo == "Alumno") {
					$consultaSQL = "INSERT INTO t_notas (alumno, nota) VALUES ('".$usuario."',null);";  
					if ($conexion->query($consultaSQL) === FALSE) {
						echo "Error: ".$conexion->error;
						return false;								
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	function eliminarUsuario ($usuario) {
		global $conexion;
		$consultaSQL = "DELETE FROM t_usuarios WHERE usuario='".$usuario."';";
		if ($conexion->query($consultaSQL) === FALSE) {
			echo "Error: ".$conexion->error;
		}
	}
?>