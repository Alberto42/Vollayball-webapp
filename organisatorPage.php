<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$teams = pg_query($link,"SELECT nazwa FROM druzyna");
?>
<html>
<head>
    <title>Strona organizatora</title>
</head>
<body>
    <form method="post" action="addTeam.php">
        <h3>Dodaj drużynę:</h3>
        <input type="text" name="name"/>
        <input type="submit" value="Dodaj"/>
    </form>
    <br/>
    <h3>Dodaj gracza</h3>
    <form method="post" action="addPlayer.php" id="addPlayer">
        Drużyna
        <select name="team">
            <?php
            $teams = pg_query($link,"SELECT nazwa FROM druzyna");
            $numrows = pg_numrows($teams);
            for($ri = 0; $ri < $numrows; $ri++) {
                $row = pg_fetch_array($teams, $ri);
                $teamName = $row["nazwa"];
                if ($teamName != "Mecz nierozegrany") {
                    echo "<option value=\"$teamName\">" . $teamName . "</option>";
                }
            }
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
</body>
</html>