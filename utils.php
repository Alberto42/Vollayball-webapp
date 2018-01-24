<?php
function connect() {
    global $link;
    $link = pg_connect("
        host=labdb
        dbname=bd
        user=ac370756
        password=maslo
        ");

}

function teamsDropDown($numrows, $teams)
{
    for ($ri = 0; $ri < $numrows; $ri++) {
        $row = pg_fetch_array($teams, $ri);
        $teamName = $row["nazwa"];
        if ($teamName != "Mecz nierozegrany") {
            echo "<option value=\"$teamName\">" . $teamName . "</option>";
        }
    }
}

function areApplicationsOpen($link)
{
    $checkIfOpenQuery = pg_query($link, "SELECT dostepne FROM dostepnosczgloszen");
    $open = pg_fetch_array($checkIfOpenQuery, 0);
    return $open["dostepne"];
}

function checkIfRowExists($link, $givenTeamExistance)
{
    $checkIfTeamExists = pg_query($link, $givenTeamExistance);
    $numrows = pg_numrows($checkIfTeamExists);
    if ($numrows > 0) {
        echo "<h3>Błąd! Istnieje już taki wiersz</h3><br>";
        echo "<a href=\"../organisatorPage.php\"> Wroc</a>";
        exit;
    }
}
?>
