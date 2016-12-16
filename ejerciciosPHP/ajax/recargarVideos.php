<?php
header("Content-type: text/javascript");
if (isset($_GET['id'])) {
	
	// Parámetros enviados en la URL para recargar un vídeo en particular:
	$id = $_GET['id'];
	$tiempo = $_GET['tiempo'];
	$paramVideo = "?rel=0&showinfo=0&autoplay=1&start=".$tiempo."' frameborder='0' allowfullscreen";

	if ($id == 'video1') {
		$video = "<iframe width='560' height='315' src='https://www.youtube.com/embed/5l5Xn_LOEY4".$paramVideo."></iframe>";
	} else {
		$video = "<iframe width='560' height='315' src='https://www.youtube.com/embed/voywIbE8P7M".$paramVideo."></iframe>";
	}
	// código JavaScript generado para recargar el vídeo en cuestión y en el segundo indicado:
	echo "document.getElementById(\"" . $id . "\").innerHTML=\"".$video."\"";
}
?>