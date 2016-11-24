<HTML>
    <HEAD>
        <TITLE>Título de la página</TITLE>
    </HEAD>
    <BODY>

    <table border="1">
    <?php
        $cont=1;
        for($i=0;$i<5;$i++){
            echo "<tr>";
                for($j=0;$j<7;$j++){
                    $rgb=$cont*7;
                    echo "<td style=\"background:rgb(".$rgb.",".$rgb.",".$rgb.")\">".$cont."</td>";
                    $cont++;
                }
            echo "</tr>";
        }
    ?>
    </table>

    </BODY>
</HTML>