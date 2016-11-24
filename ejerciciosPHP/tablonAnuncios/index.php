<?php
libxml_use_internal_errors(true);
$noticias = simplexml_load_file("Noticias.xml");
if ($noticias === false)
echo "Error en el archivo XML";
//print_r($noticias);
?>

<html>
<head>
  <title> Noticias </title>
</head>

<body bgcolor="#00BBAA">

  <img src="imagenes/tablon.gif"/>

<?php foreach($noticias->Noticia as $noticia): ?>

  <div style="

    <?php
    echo "position:absolute;";
    echo "left:".$noticia->X.";";
    echo "top:".$noticia->Y.";";
    echo "width:".$noticia->Ancho.";";
    echo "height:".$noticia->Alto.";";
    ?>

  ">

    <div style="

      <?php
      echo "position:absolute;";
      echo "left:5px;";
      echo "top:20px;";
      echo "width:".$noticia->Ancho.";";
      echo "height:".$noticia->Alto.";";
      ?>

  ">
      <img

      <?php
      echo 'src="imagenes/post-it.png"';
      echo "width=".$noticia->Ancho." ";
      echo "height=".$noticia->Alto;
      ?>

      ></img>
    </div>

    <div style="

      <?php
      echo "position:relative;";
      echo "left:25px;";
      echo "top:25px;";
      echo "width:".$noticia->Ancho.";";
      echo "height:".$noticia->Alto.";";
      ?>

    ">
      <p style="

      <?php
      echo "width:".$noticia->Ancho.";";
      echo "height:".$noticia->Alto.";";
      echo "color:".$noticia->ColorTexto.";";
      echo "font-size:".$noticia->TamanoTexto.";";
      echo "font-family:Script;";
      ?>

      "><?php echo $noticia->Texto; ?><p>

    </div>

    <div style="
      position:absolute;
      left:-5px;
      top:-5px;">
      <img src="imagenes/chincheta.png"</img>
    </div>
  </div>

<?php endforeach; ?>

</body>
</html>
