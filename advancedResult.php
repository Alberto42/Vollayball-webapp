<html>
<head>
    <title>Szczegoly meczu</title>
</head>
<body>

<h3>Składy drużyn</h3>
<table border="1">
    <?php
    $link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
    $match = $_GET["mecz"];
    $players1 = pg_query($link,
        "SELECT imie,nazwisko FROM zawodnik_sklad
JOIN zawodnik ON zawodnik_sklad.id_zawodnik = zawodnik.id
WHERE id_sklad =  (SELECT sklad_1 FROM mecz WHERE mecz.id = $match)");
    $players2 = pg_query($link,
        "SELECT imie,nazwisko FROM zawodnik_sklad
JOIN zawodnik ON zawodnik_sklad.id_zawodnik = zawodnik.id
WHERE id_sklad =  (SELECT sklad_2 FROM mecz WHERE mecz.id = $match)");
    $teamName1 = pg_query("SELECT nazwa FROM mecz
  JOIN sklad ON mecz.sklad_1 = sklad.id
  JOIN druzyna ON sklad.druzyna = druzyna.id
WHERE mecz.id = $match");
    $teamName2 = pg_query("SELECT nazwa FROM mecz
  JOIN sklad ON mecz.sklad_2 = sklad.id
  JOIN druzyna ON sklad.druzyna = druzyna.id
WHERE mecz.id = $match");
    $sets = pg_query("SELECT wynik1,wynik2 FROM set
WHERE mecz = $match");
    $winner = pg_query("SELECT nazwa FROM mecz
  JOIN druzyna ON druzyna.id = zwyciezca
WHERE mecz.id=$match");

    $numrows = 6;
    $teamName1 = pg_fetch_array($teamName1, 0)["nazwa"];
    $teamName2 = pg_fetch_array($teamName2, 0)["nazwa"];
    $winner = pg_fetch_array($winner,0)["nazwa"];
    echo "<tr><th>$teamName1</th></tr>";
    for ($ri = 0; $ri < $numrows; $ri++) {
        echo "<tr>\n";
        $row = pg_fetch_array($players1, $ri);
        echo " <td>" . $row["imie"] . " " . $row["nazwisko"] . "</td>

    </tr>
    ";
    }
    ?>
</table>
<br>
<table border="1">
    <?php
    echo "<tr><th>$teamName2</th></tr>";
    for ($ri = 0; $ri < $numrows; $ri++) {
        echo "<tr>\n";
        $row = pg_fetch_array($players2, $ri);
        echo " <td>" . $row["imie"] . " " . $row["nazwisko"] . "</td>

    </tr>
    ";
    }
    ?>

</table>
<br>
<?php
    if ($winner == "Mecz nierozegrany") {
        echo "<h3>Mecz nierozegrany</h3>";
    } else {
        echo "
            <h4>Zwyciezyli: $winner</h4>
            <h3>Wyniki odbytych setow</h3>
            <table border=\"1\">
            <tr>
                <th>$teamName1</th>
                <th>$teamName2</th>
            </tr>
        ";
        for ($ri = 0; $ri < pg_numrows($sets); $ri++) {
            echo "<tr>\n";
            $row = pg_fetch_array($sets, $ri);
            echo " <td>" . $row["wynik1"] . "</td>
            <td>" . $row["wynik2"] . "</td>

            </tr>
            ";
        }
        echo "</table>";
    }
    pg_close($link);
    ?>

</body>
</html>