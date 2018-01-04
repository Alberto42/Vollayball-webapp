<?php
include '../../utils.php';
connect();
$name = $_POST["name"];

$checkIfOpenQuery = pg_query($link,"SELECT dostepne FROM dostepnosczgloszen");
$open = pg_fetch_array($checkIfOpenQuery,0)["dostepne"];
if ($open == "t") {
    pg_query($link, "INSERT INTO druzyna
  VALUES (nextval('druzyna_id_seq1'::regclass),'$name')");
    echo "<h3>Dodano druzyne: $name</h3>";
} else {
    echo "<h3>Zgloszenia zamkniete</h3>";
}
pg_close($link);
?>

