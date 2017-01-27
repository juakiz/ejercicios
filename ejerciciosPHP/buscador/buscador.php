<?php
	require("funciones.php");
	
	$marca = $motor = $anyo = $km = $precio = "";
	   
	// captura de parámetros de búsqueda:   
	/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['marca']))
			$marca = strtoupper($_POST['marca']);
		if (isset($_POST['motor']))
			$motor = strtoupper($_POST['motor']);
		if (isset($_POST['anyo']))
			$anyo = $_POST['anyo'];
		if (isset($_POST['km']))
			$km = $_POST['km'];
		if (isset($_POST['precio']))
			$precio = $_POST['precio'];
	}*/
	
	libxml_use_internal_errors(true);
	$Coches = simplexml_load_file("coches.xml") or die("No se encuentra el archivo .xml");
	if ($Coches === false)
		echo "Error en el archivo XML";	
	//print_r($Coches->Coche);
	echo '<pre>'; foreach($Coches->Coche as $coche) echo json_encode($coche)."\n"; echo '</pre>';
	//echo json_encode($Coches->Coche);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Buscador de Coches</title>
	<style>
		.principal { font-family: verdana; font-size: 26px; color: #0088DD; font-weight: bold; }
		.titulo { font-family: verdana; font-size: 15px; color: #0000DD; }
		.parrafo { font-family: arial; font-size: 12px; color: #0000DD; }
		.boton { height: 30px; width: 145px; border-radius:2px 2px 2px 2px; border:1px solid #00DDEE; background: #0088DD; font-family: Arial; font-size: 12px; color: #FFF; text-shadow: 0 1px #aa4040; font-weight: bold; }
		th { font-family: verdana; font-size: 16px; color: #0088DD; }
		.resaltado { font-family:verdana; font-size:15px; color:#000066; background:#CCCCCC; }
	</style>
			
</head>
<body bgcolor="#DDDDEE"> 	
	<p><span class="principal">
		BUSCADOR DE COCHES
	</span></p> 
	 
	<table class="titulo" style="border: 1px solid #0000DD; width:630px; background:#CCCCCC;" border="0" cellpadding="10">
		<tr>
			<td>
			  Marca: 
			  <?php			  
					crearSelect($Coches->Coche, "marca", $marca);
			  ?>
			</td>
			<td>
			  Motor: 
			  <?php
					crearSelect($Coches->Coche, "motor", $motor);
			  ?>
			</td>
			<td>
			  Año: 
			  <?php
					crearSelect($Coches->Coche, "anyo", $anyo);
			  ?>
			</td>
			<td>
			  Km (hasta):
			  <?php
					crearSelect($Coches->Coche, "km", $km);
			  ?>
			</td>
			<td>
			  Precio (hasta):
			  <?php
					crearSelect($Coches->Coche, "precio", $precio);
			  ?>
			</td>
		</tr>
		<!--<tr>
			<td colspan="4" align="center">
				<input type="submit" name="buscar" value="BUSCAR" class="boton">
			</td>
		</tr>-->
	</table>
	<br>
	<div id="tablaCoches"></div>
	<?php
	    /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// buscar coches
			$arrayCoches = buscarCoches($Coches->Coche, $marca, $motor, $anyo, $km, $precio);
			mostrarTablaCoches($arrayCoches);				
		} else {
			// mostrar todos los coches
			mostrarTablaCoches($Coches->Coche);	
		}*/
	?>
	
	<!-- marco de la derecha donde se mostrará el coche seleccionado -->
	<div id="coche" style="position:absolute; left:640px; top:63px; width:330px; height:200px; border-collapse:collapse; border:1px solid #0000DD; text-align:center; padding:20px 0;">
	</div>

	<script language="javascript" type="application/javascript">
		function cambiarColorOver (fila) { 
			fila.style.backgroundColor = "#CCCCCC"; 
			//fila.className = "resaltado";
		}
		
		function cambiarColorOut (fila)  { 
			fila.style.backgroundColor = "#DDDDEE"; 
			//fila.className = "titulo";
		}
		
		function mostrarCoche (idImg)  { 
			// muestra la imagen ampliada del coche en el div de la derecha
			var URLimagen = document.getElementById(idImg).src;
			var anchoAmpliado = document.getElementById(idImg).width * 3;
			var altoAmpliado = document.getElementById(idImg).height * 3;
			var imagenAmpliada = "<img src=\"" + URLimagen + "\"" + " width=\"" + anchoAmpliado + "\"" + " height=\"" + altoAmpliado + "\">";
			document.getElementById("coche").innerHTML = imagenAmpliada;
		}

		function buscarCochesAJAX (atributo, valor) {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("tablaCoches").innerHTML = this.responseText;
				}
			};
			xhr.open("POST", "funciones.php", true);
			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			parametros = "atributo=" + atributo + "&" + "valor=" + valor;
			xhr.send(parametros);
		}
    </script>
</body>
</html>