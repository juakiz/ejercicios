<?php
	require("funciones.php");
	
	$marca = $motor = $km = $precio = "";
	   
	// captura de parámetros de búsqueda:   
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['marca']))
			$marca = strtoupper($_POST['marca']);
		if (isset($_POST['motor']))
			$motor = strtoupper($_POST['motor']);
		if (isset($_POST['km']))
			$km = $_POST['km'];
		if (isset($_POST['precio']))
			$precio = $_POST['precio'];
	}
	
	libxml_use_internal_errors(true);
	$Coches = simplexml_load_file("coches.xml") or die("No se encuentra el archivo .xml");
	if ($Coches === false)
		echo "Error en el archivo XML";	
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
		
		<script language="javascript" type="text/javascript">
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
	    </script>
		
</head>
<body bgcolor="#DDDDEE"> 	
	<p><span class="principal">
		BUSCADOR DE COCHES
	</span></p> 
	
	<form name="buscar" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
	<table class="titulo" style="border: 1px solid black; width:600px; background:#CCCCCC;" border="0" cellpadding="10">
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
		<tr>
			<td colspan="4" align="center">
				<input type="submit" name="buscar" value="BUSCAR" class="boton">
			</td>
		</tr>
	</table>
	</form>
	<br>

	
	<?php
	    if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// buscar coches
			$arrayCoches = buscarCoches($Coches->Coche, $marca, $motor, $km, $precio);
			mostrarTablaCoches($arrayCoches);				
		} else {
			// mostrar todos los coches
			mostrarTablaCoches($Coches->Coche);	
		}
	?>
	
	<!-- marco de la derecha donde se mostrará el coche seleccionado -->
	<div id="coche" style="position:absolute; left:640px; top:63px; width:330px; height:200px; border-collapse:collapse; border:1px solid black; text-align:center; padding:20px 0;">
	</div>
	
</body>
</html>
