<?php
// Carga XML
libxml_use_internal_errors(true);
$compra = simplexml_load_file("productos.xml");
if ($compra === false)
echo "Error en el archivo XML";
print_r($compra);
session_start();

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
<tr><th></th><th>Producto</th><th>Precio</th><th>Cantidad</th><th></th></tr>
<?php
foreach ($compra->Producto as $producto) {
	echo "<tr><td>".$producto->Imagen."</td>";
	echo "<tr><td>".$producto->Nombre."</td>";
	echo "<tr><td>".$producto->Precio."</td>";
	echo "<td>".$cesta[key($compra)]."</td><td>"; // escribe el valor de la variable de sesión
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