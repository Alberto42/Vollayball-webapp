<?php
include '../../utils.php';
connect();
$players = $_POST['playerIds'];
$skladId = $_GET['skladId'];
$N = count($players);
if($N != 6)
{
    echo("Zła liczba graczy");
}
else
{
    for($playerIndex=0; $playerIndex < $N; $playerIndex++)
    {
        $playerId = $players[$playerIndex];
        pg_query($link,"INSERT INTO zawodnik_sklad
            VALUES($playerId,$skladId)");
    }
    echo("Dodano sklad");
}
pg_close($link);
?>