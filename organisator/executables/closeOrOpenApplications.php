<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 04.01.18
 * Time: 13:36
 */
include '../../utils.php';
$open = $_GET["open"];
if ($open == "t") {
    $dostepne = "FALSE";
    $text = "zamknięte";
}
else {
    $dostepne = "TRUE";
    $text = "otwarte";
}
connect();
pg_query($link,"UPDATE dostepnosczgloszen SET dostepne = $dostepne");
pg_close($link);
echo "<h3>Zgłoszenia zostały $text</h3>";

echo "<a href=\"../organisatorPage.php\"> Wroc</a>";