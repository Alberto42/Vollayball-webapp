<html>
<head>
    <title>Mecze druzyny</title>
</head>

<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$result = pg_query($link,
    "SELECT druzyna1.nazwa nazwa1,druzyna2.nazwa nazwa2, druzynaZwyciezka.nazwa zwyciezca FROM mecz
JOIN sklad sklad1 ON sklad1.id = mecz.sklad_1
JOIN sklad sklad2 ON sklad2.id = mecz.sklad_2
JOIN druzyna druzyna1 ON druzyna1.id = sklad1.druzyna
JOIN druzyna druzyna2 ON druzyna2.id = sklad2.druzyna
LEFT JOIN druzyna druzynaZwyciezka ON druzynaZwyciezka.id = mecz.zwyciezca");
$numrows = pg_numrows($result);
?>
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
</body>
</html>