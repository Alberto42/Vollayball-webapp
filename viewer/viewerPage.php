<?php
include '../utils.php';
connect();
$teams = pg_query($link, "SELECT nazwa FROM druzyna");

$numrows = pg_numrows($teams);
pg_close($link);
?>
<html>
<head>
    <title>Strona kibica</title>
</head>
<h1 align="center">Strona kibica</h1>
<form method="post" action="matchByTeam.php">
    <input type="hidden" name="druzyna" value="%" />
    <input type="submit" value="Pokaz wszystkie mecze" />
</form>
<h3>Szukaj po druzynie</h3>
<form method="post" action="matchByTeam.php">
    Nazwa druzyny
    <select name="team">
        <?php
        teamsDropDown($numrows, $teams);
        ?>
    </select>
    <input type="submit" value="Szukaj">
</form>
<br>
<h3>Szukaj po zawodniku</h3>
<form method="post" action="matchByPlayer.php">
    Imie zawodnika
    <input type="text" name="imie">
    <br>
    Nazwisko zawodnika
    <input type="text" name="nazwisko">
    <br>
    <input type="submit" value="Szukaj">
</form>
</html>