<?php
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$winsA=0;$winsB=0;
$match = $_GET["mecz"];
for($i=1;$i<=5;$i++) {
    $pointsA = $_POST["set".$i."A"];
    $pointsB = $_POST["set".$i."B"];
    if ($pointsA == 0 && $pointsB == 0)
        break;
    if ($pointsA > $pointsB)
        $winsA++;
    else
        $winsB++;
    pg_query($link,"INSERT INTO set
        VALUES(nextval('set_id_seq1'::regclass),$pointsA,$pointsB,$match)");
}
if ($winsA > $winsB)
    $winner = "1";
else $winner = "2";
pg_query($link,"UPDATE mecz SET zwyciezca =
(
    SELECT sklad.druzyna
    FROM mecz
    JOIN sklad ON mecz.sklad_$winner = sklad.id
    WHERE mecz.id = $match
)
WHERE mecz.id = $match")
?>