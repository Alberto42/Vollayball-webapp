<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$name = $_POST["name"];
$surname = $_POST["surname"];
$team = $_POST["team"];

pg_query($link,"INSERT INTO zawodnik
SELECT nextval('zawodnik_id_seq1'::regclass), '$name', '$surname', druzyna.id
FROM druzyna
WHERE druzyna.nazwa = '$team';" );
echo "<h3>Dodano gracza: $name $surname do druzyny $team</h3>";

?>