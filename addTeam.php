<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$name = $_POST["name"];

pg_query($link,"INSERT INTO druzyna
  VALUES (nextval('druzyna_id_seq1'::regclass),'$name')" );

echo "<h3>Dodano druzyne: $name</h3>";
?>

