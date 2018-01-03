<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$druzyna = $_GET["druzyna"];
$players = pg_query($link,"SELECT zawodnik.imie imie, zawodnik.nazwisko nazwisko, zawodnik.id id
FROM zawodnik
WHERE zawodnik.druzyna =
      (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = '$druzyna')");

$numrows = pg_numrows($players);

?>
<h3>Wybierz 6 graczy do tego meczu</h3>
<?php
$skladId = $_GET["skladId"];
echo "<form method=\"post\" action=\"addSubset.php?skladId=$skladId\">";
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

<?php
pg_close($link);
?>
