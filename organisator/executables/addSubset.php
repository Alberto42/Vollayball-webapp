<?php
include '../../utils.php';
connect();
$players = $_POST['playerIds'];
$skladId = $_GET['skladId'];
$N = count($players);
if($N != 6)
{
    echo("<h3>Zła liczba graczy</h3>");
}
else
{
    for($playerIndex=0; $playerIndex < $N; $playerIndex++)
    {
        $playerId = $players[$playerIndex];
        pg_query($link,"INSERT INTO zawodnik_sklad
            VALUES($playerId,$skladId)");
    }
    echo("<h3>Dodano sklad</h3>");
}
pg_close($link);

echo "<a href=\"../organisatorPage.php\"> Wroc</a>";
?>