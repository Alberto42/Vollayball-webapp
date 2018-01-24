<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include '../../utils.php';
$name = $_POST["name"];
$surname = $_POST["surname"];
$team = $_POST["team"];

connect();

checkIfRowExists($link, "SELECT id FROM zawodnik
  WHERE zawodnik.imie = '$name' AND zawodnik.nazwisko = '$surname'");

$open = areApplicationsOpen($link);
if ($open == "t") {
    pg_query($link, "INSERT INTO zawodnik
      SELECT nextval('zawodnik_id_seq1'::regclass), '$name', '$surname', druzyna.id
      FROM druzyna
      WHERE druzyna.nazwa = '$team';");
    echo "<h3>Dodano gracza: $name $surname do druzyny $team</h3>";
} else {
    echo "<h3>Zgloszenia zamkniete</h3>";
}
pg_close($link);

echo "<a href=\"../organisatorPage.php\"> Wroc</a>";
?>
