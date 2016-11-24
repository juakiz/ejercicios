<?php
// Carga XML
libxml_use_internal_errors(true);
$portatiles = simplexml_load_file("portatiles.xml");
if ($portatiles === false)
echo "Error en el archivo XML";
//print_r($portatiles);

/*
if (isset($_COOKIE['cookieCheck'])){

}
}*/
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Catálogo de Portátiles</title>
		<style>
			.principal { font-family: arial; font-size: 20px; color: #0022DD; font-weight: bold; }
			.titulo { font-family: verdana; font-size: 15px; color: #0000DD; }
			.parrafo { font-family: arial; font-size: 12px; color: #0000DD; }
			.boton { height: 30px; width: 145px; border-radius:2px 2px 2px 2px; border:1px solid #00DDEE; background: #0088DD; font-family: Arial; font-size: 12px; color: #FFF; text-shadow: 0 1px #aa4040; font-weight: bold; }
			td { font-family: arial; font-size: 14px; color: #0000DD; }
			th { font-family: verdana; font-size: 16px; color: #0088DD; }
			.resaltado { font-family: verdana; font-size: 14px; color: #00EE55; font-weight: bold; }
		</style>
	</head>
<body> 	
	<p><span class="principal">
		CATÁLOGO DE PORTÁTILES
	</span></p> 
	
	<table class="titulo" style="border: 1px solid black;" border="0" cellpadding="10">
		<tr>
		<td>
		<form name="buscar_por_marca" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
		  Marca: <input type="text" name="marca" value="" size="14" required>
		  <br><br>		  
		  <input type="hidden" name="tipo_formulario" value="marca">
		  <input type="submit" name="submit" value="BUSCAR por MARCA" class="boton">
		</form>
		</td>

		<td>
		<form name="buscar_por_precio" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
		  Precio menor que: <input type="number" name="precio" min="1" max="999" value="" required style="width: 8em;">
		  <br><br>
		  <input type="hidden" name="tipo_formulario" value="precio">
		  <input type="submit" name="submit" value="BUSCAR por PRECIO" class="boton">
		</form>
		</td>
		</tr>
	</table>
	<br>

	<table class="titulo" style="border: 1px solid black;" border="0" cellpadding="10">
		<tr>
			<th>Marca</th>
			<th>Procesador</th>
			<th>RAM</th>
			<th>Disco</th>
			<th>Precio</th>
		</tr>
<?php
	if($_SERVER["REQUEST_METHOD"] != "POST"){



		foreach($portatiles->Portatil as $portatil){
			echo "<tr>";
				echo '<td><input type="checkbox" name="'.$portatil->Precio.'"></td>';
				echo "<td>".$portatil->Marca."</td>";
				echo "<td>".$portatil->Procesador."</td>";
				echo "<td>".$portatil->RAM."</td>";
				echo "<td>".$portatil->Disco."</td>";
				echo "<td>".$portatil->Precio."</td>";
			echo "</tr>";
		}

		// Por Marca
	} else if ($_POST['tipo_formulario'] == "marca") {
		$marcaF = $_POST['marca'];

		foreach($portatiles->Portatil as $portatil){
			$marcaX = $portatil->Marca;

			if($marcaX==$marcaF)
			echo '<tr style="background:gray">';
			else
			echo "<tr>";
				echo '<td><input type="checkbox" name="'.$portatil->Precio.'"></td>';
				echo "<td>".$portatil->Marca."</td>";
				echo "<td>".$portatil->Procesador."</td>";
				echo "<td>".$portatil->RAM."</td>";
				echo "<td>".$portatil->Disco."</td>";
				echo "<td>".$portatil->Precio."</td>";
			echo "</tr>";
		}

		// Por Precio
	} else if ($_POST['tipo_formulario'] == "precio") {

		foreach($portatiles->Portatil as $portatil){
			if($_POST['precio']>$portatil->Precio){
			echo "<tr>";
				echo '</td><input type="checkbox" name="'.$portatil->Precio.'"></td>';
				echo "<td>".$portatil->Marca."</td>";
				echo "<td>".$portatil->Procesador."</td>";
				echo "<td>".$portatil->RAM."</td>";
				echo "<td>".$portatil->Disco."</td>";
				echo "<td>".$portatil->Precio."</td>";
			echo "</tr>";
		}
	}


	}

?>
	</table>
	
	
	<br>
	<form name="guardar" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
		<input type="hidden" name="tipo_formulario" value="guardar">
		<input type="submit" name="submit" value="GUARDAR" class="boton">
	</form>	
<?php
/*
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		foreach():
		$precio=$_POST[$portatil->Precio];
		if(isset($precio)){
			setcookie("cookieCheck[$precio]", "1", time()+2592000);
		}
		endforeach;
	}
	*/
?>
</body>
</html>
