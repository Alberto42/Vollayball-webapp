<?php

?>
<h2 align=center>Mecze:</h2>

<table border="1" align=center>
    <tr>
        <th>Pierwsza drużyna</th>
        <th>Druga drużyna</th>
        <th>Wynik</th>
        <th>Zwycięzca</th>
    </tr>
    <?php

    for($ri = 0; $ri < $numrows; $ri++) {
        echo "<tr>\n";
        $row = pg_fetch_array($result, $ri);
        $match = $row["id"];
        $points1 = pg_fetch_array(pg_query($link,
            "SELECT COUNT(*) wynik FROM set 
            WHERE mecz = $match AND set.wynik1 > set.wynik2"),0)["wynik"];
        $points2 = pg_fetch_array(pg_query($link,
            "SELECT COUNT(*) wynik FROM set 
            WHERE mecz = $match AND set.wynik1 < set.wynik2"),0)["wynik"];
        $points = $points1 . " : " . $points2;
        if ($row["zwyciezca"] == "Mecz nierozegrany")
            $points = "";
        echo " <td>" . $row["nazwa1"] . "</td>
     <td>" . $row["nazwa2"] . "</td>
     <td>" . $points . "</td>
     <td>" . $row["zwyciezca"] . "</td>
     <td> <a href=\"advancedResult.php?mecz=$match\">Szczegoly meczu</a> </td>

    </tr>
    ";
    }
    pg_close($link);
    ?>
</table>