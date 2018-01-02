<h2 align=center>Rozegrane mecze:</h2>

<table border="1" align=center>
    <tr>
        <th>Pierwsza drużyna</th>
        <th>Druga drużyna</th>
        <th>Zwycięzca</th>
    </tr>
    <?php

    for($ri = 0; $ri < $numrows; $ri++) {
        echo "<tr>\n";
        $row = pg_fetch_array($result, $ri);
        echo " <td>" . $row["nazwa1"] . "</td>
     <td>" . $row["nazwa2"] . "</td>
     <td>" . $row["zwyciezca"] . "</td>
    </tr>
    ";
    }
    pg_close($link);
    ?>
</table>