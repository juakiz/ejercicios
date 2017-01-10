<?php
	session_start();

	if (isset($_SESSION['si'])) {
		$si = $_SESSION['si'];
	} else {
		$_SESSION['si'] = 0;
		$si = 0;
	}

	if (isset($_SESSION['no'])) {
		$no = $_SESSION['no'];
	} else {
		$_SESSION['no'] = 0;
		$no = 0;
	}
	   
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['si'])) {
			$si++;
			$_SESSION['si'] = $si;
		}
		if (isset($_POST['no'])) {
			$no++;
			$_SESSION['no'] = $no;
		} 
	}
?>

	  <?php 
		$ancho = $si * 10;
		echo "<div style=\"width:".$ancho."px; height:22px; background:rgb(100,255,100);\">";
		echo $si;
		echo "</div>";
	  ?>

	  	<?php
			if ($si+$no != 0) {
				$porcentaje = $si/($si+$no) * 100;
				echo $porcentaje."%";
			} else {
				echo "0%";
			}
	  	?>

	  <?php 
		$ancho = $no * 10;
		echo "<div style=\"width:".$ancho."px; height:22px; background:rgb(255,100,100);\">";
		echo $no;
		echo "</div>";
	  ?>

	  	<?php
			if ($si+$no != 0) {
				$porcentaje = $no/($si+$no) * 100;
				echo $porcentaje."%";
			} else {
				echo "0%";
			}
	  	?>