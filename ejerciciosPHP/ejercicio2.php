<HTML>
    <HEAD>
        <TITLE>Título de la página</TITLE>
    </HEAD>
    <BODY>

    <table border="1">
    <?php

        echo "<tr>";
            for($i=0 ; $i<6 ; $i++){
                echo "<td>";
                
                do{
                    $cond=false;
                    $numRand[$i]=rand(1,6);
                    //echo $numRand[$i];
                    //var_dump($numRand);
                    for($j=count($numRand)-1 ; $j > 0 ; $j--){
                        if($numRand[$i]==$numRand[$j-1]) {
                            //echo "<br> ENTRA i=".$numRand[$i]."  j=".$numRand[$j];
                            $cond=true;
                        }
                    }
                 
                }while($cond == true);
                
                echo $numRand[$i]."</td>";
                
            }
        echo "</tr>";

    ?>
    </table>

    </BODY>
</HTML>