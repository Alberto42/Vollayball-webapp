<?php
include '../utils.php';
connect();
$teams = pg_query($link, "SELECT nazwa FROM druzyna");

$numrows = pg_numrows($teams);

function teamsDropDown($numrows, $teams): array
{
    for ($ri = 0; $ri < $numrows; $ri++) {
        $row = pg_fetch_array($teams, $ri);
        $teamName = $row["nazwa"];
        if ($teamName != "Mecz nierozegrany") {
            echo "<option value=\"$teamName\">" . $teamName . "</option>";
        }
    }
    return array($ri, $row, $teamName);
}

?>
<html>
<head>
    <title>Strona organizatora</title>
</head>
<body>
<form method="post" action="executables/addTeam.php">
    <h3>Dodaj drużynę:</h3>
    <input type="text" name="name"/>
    <input type="submit" value="Dodaj"/>
</form>
<br/>
<h3>Dodaj gracza</h3>
<form method="post" action="executables/addPlayer.php" id="addPlayer">
    Drużyna
    <select name="team">
        <?php
        teamsDropDown($numrows, $teams);
        ?>
    </select>
    <br/>
    Imie
    <input type="text" name="name"/>
    <br/>
    Nazwisko
    <input type="text" name="surname"/>
    <br/>
    <input type="submit" value="Dodaj"/>
</form>
<br/>
<h3>Dodaj mecz</h3>
<form method="post" action="executables/addMatch.php" id="addMatch">
    Druzyna A
    <select name="teamA">
        <?php
        teamsDropDown($numrows, $teams);
        ?>
    </select>
    <br/>
    Druzyna B
    <select name="teamB">
        <?php
        teamsDropDown($numrows, $teams);
        ?>
    </select>
    <br/>
    <input type="submit" value="Dodaj"/>
</form>
<?php include 'futureMatches.php'; ?>
<h3><a href="executables/closeApplications.php">Zamknij zgloszenia</a></h3>
</body>
</html>