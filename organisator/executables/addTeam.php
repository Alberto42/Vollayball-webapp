<?php
include '../../utils.php';
connect();
$name = $_POST["name"];

checkIfRowExists($link, "SELECT nazwa FROM druzyna WHERE nazwa = '$name'");

$open = areApplicationsOpen($link);
if ($open == "t") {
    pg_query($link, "INSERT INTO druzyna
  VALUES (nextval('druzyna_id_seq1'::regclass),'$name')");
    echo "<h3>Dodano druzyne: $name</h3>";
} else {
    echo "<h3>Zgloszenia zamkniete</h3>";
}
pg_close($link);

echo "<a href=\"../organisatorPage.php\"> Wroc</a>";
?>

