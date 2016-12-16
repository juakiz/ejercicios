<?php
session_start();
// Productos en venta:
$productos[0] = "Portátil X"; 
$productos[1] = "Móvil Y"; 
$productos[2] = "Tablet Z";

if (isset($_SESSION['cesta']))
	$cesta = $_SESSION['cesta']; // si existe la sesión, carga la cesta
else
	$cesta = array(0, 0, 0); // si no existe la sesión pone a 0 todos los productos
if ($_SERVER['REQUEST_METHOD'] == "POST") { // incrementa/decrementa la cantidad del producto
	$operacion = $_POST['boton'];
	$producto = $_POST['producto'];
	if ($operacion == "+")
		$cesta[$producto]++;
	else {
		if ($cesta[$producto] != 0)
			$cesta[$producto]--;
	}
	$_SESSION['cesta'] = $cesta; // y guarda el nuevo valor
} // en la variable de sesión
?>
<html>
<head> <title> Cesta de la compra </title>
<style>
	.principal { font-family: arial; font-size: 20px; color: #0022DD; font-weight: bold; }
	.titulo { font-family: verdana; font-size: 15px; color: #0000DD; }
</style>
</head>
<body bgcolor="#DDDDFF">
<p class="principal">CESTA DE LA COMPRA</p>
<p class="titulo">Seleccione sus productos:</p>
<table class="titulo" style="border: 1px solid black;" border="0" cellpadding="10">
<tr><th>Producto</th><th>Cantidad</th><th></th></tr>
<?php
foreach ($productos as $posicion=>$nombre) {
	echo "<tr><td>".$nombre."</td>";
	echo "<td>".$cesta[$posicion]."</td><td>"; // escribe el valor de la variable de sesión
	echo "<form method=\"post\" action=\"\">";
	echo "<input type=\"submit\" name=\"boton\" value=\"+\">";
	echo "<input type=\"submit\" name=\"boton\" value=\"-\">";
	echo "<input type=\"hidden\" name=\"producto\" value=\"".$posicion."\">";
	echo "</form>";
	echo "</td></tr>";
}
?>
</table>
</body>
</html>