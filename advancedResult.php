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
WHERE mecz.id = 1");
$teamName2 = pg_query("SELECT nazwa FROM mecz
  JOIN sklad ON mecz.sklad_2 = sklad.id
  JOIN druzyna ON sklad.druzyna = druzyna.id
WHERE mecz.id = 1");

$numrows = 6;
$teamName1 = pg_fetch_array($teamName1, 0)["nazwa"];
$teamName2 = pg_fetch_array($teamName2, 0)["nazwa"];
echo "<tr><th>$teamName1</th></tr>";
for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($players1, $ri);
    echo " <td>" . $row["imie"] . " " . $row["nazwisko"] . "</td>

    </tr>
    ";
}
echo "</table>";
echo "<table border=\"1\">";
echo "<tr><th>$teamName2</th></tr>";
for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($players2, $ri);
    echo " <td>" . $row["imie"] . " " . $row["nazwisko"] . "</td>

    </tr>
    ";
}
echo "</table>\n";
pg_close($link);
?>

</body>
</html>