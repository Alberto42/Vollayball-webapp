<?php
function connect() {
    global $link;
    $link = pg_connect("
        host=localhost 
        dbname=postgres2
        user=postgres 
        password=postgres
        ");

}

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