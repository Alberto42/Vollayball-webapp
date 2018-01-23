<?php
include '../utils.php';
connect();
$druzyna = $_GET["druzyna"];

$players = pg_query($link,"
SELECT zawodnik.imie imie, zawodnik.nazwisko nazwisko, zawodnik.id id
FROM zawodnik
WHERE zawodnik.druzyna =
      (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = '$druzyna')
");
pg_close($link);

$numrows = pg_numrows($players);

?>
<h3>Wybierz 6 graczy do tego meczu</h3>
<?php
$skladId = $_GET["skladId"];
echo "
<form method=\"post\" action=\"executables/addSubset.php?skladId=$skladId\">";
    for ($ri = 0; $ri < $numrows; $ri++) {
        $row = pg_fetch_array($players, $ri);
        $teamName = $row["nazwa"];
        $id = $row["id"];
        echo "<input type=\"checkbox\" name=\"playerIds[]\" value=\"$id\">"
                . $row["imie"] . " " . $row["nazwisko"] .
              "</input><br/>";
    }
    ?>
    <input type="submit" value="Wybierz"/>

</form>

<?php echo "<a href=\"organisatorPage.php\"> Wroc</a>"; ?>