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

<!DOCTYPE html>
<html>
    <head><title>Encuesta</title></head>
<body> 	
	<p><span style="font-family: verdana; font-size: 18px; color: #0022DD; font-weight: bold;">
		¿Está de acuerdo con...?
	</span></p> 
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<table>
	<tr>
	  <td>
	  <input type="submit" name="si" value="SÍ" style="height: 24px; width: 50px; border-radius:2px 2px 2px 2px; border:1px solid #0000FF; background: #0000DD; font-family: Arial; font-size: 12px; color: #00FF00; text-shadow: 0 1px #aa4040; font-weight: bold;">
	  </td> 
	  <td></td>
	  <td>
	  <?php 
		$ancho = $si * 10;
		echo "<div style=\"width:".$ancho."px; height:22px; background:rgb(100,255,100);\">";
		echo $si;
		echo "</div>";
	  ?>
	  </td>
	  <td>
	  <?php
			if ($si+$no != 0) {
				$porcentaje = $si/($si+$no) * 100;
				echo $porcentaje."%";
			} else {
				echo "0%";
			}
	  ?>
	  </td>
	</tr>
	<tr><td><br></td><td></td></tr>
	<tr>
	  <td>
	  <input type="submit" name="no" value="NO" style="height: 24px; width: 50px; border-radius:2px 2px 2px 2px; border:1px solid #0000FF; background: #0000DD; font-family: Arial; font-size: 12px; color: #FF0000; text-shadow: 0 1px #aa4040; font-weight: bold;">
	  </td>
	  <td></td>
	  <td>
	  <?php 
		$ancho = $no * 10;
		echo "<div style=\"width:".$ancho."px; height:22px; background:rgb(255,100,100);\">";
		echo $no;
		echo "</div>";
	  ?>
	  </td>
	  <td>
	  <?php
			if ($si+$no != 0) {
				$porcentaje = $no/($si+$no) * 100;
				echo $porcentaje."%";
			} else {
				echo "0%";
			}
	  ?>
	  </td>
	</tr>  
	</table>
	</form>
	<hr>
</body>
</html>
