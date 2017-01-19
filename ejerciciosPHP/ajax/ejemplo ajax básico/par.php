<html>
	<head>
		<script>
			function esPar(numero) {
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById('resultado').innerHTML = this.responseText;
					}
				};
				xhr.open("POST", "espar.php", true);
				xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				var parametros = "numero=" + numero;
				xhr.send(parametros);				
			}
		</script>
	</head>
<body>
		<input type="text" name="numero" id="numero" required onChange="esPar(document.getElementById('numero').value);" onKeyUp="esPar(document.getElementById('numero').value);">
		<!--<input type="submit" name="boton" value="ENVIAR" onClick="esPar(document.getElementById('numero').value);">-->
		<br>
		<div id="resultado">
		</div>
</body>
</html>