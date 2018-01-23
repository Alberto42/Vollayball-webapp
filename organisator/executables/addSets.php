<?php
include '../../utils.php';
connect();
$winsA=0;$winsB=0;
$match = $_GET["mecz"];
$correct=true;
for($i=1;$i<=5;$i++) {
    $pointsA = $_POST["set".$i."A"];
    $pointsB = $_POST["set".$i."B"];
    if ($pointsA == 0 && $pointsB == 0) {
        for($j=$i+1;$j<=5;$j++) {
            $pointsA = $_POST["set".$j."A"];
            $pointsB = $_POST["set".$j."B"];
            if ($pointsA != 0 || $pointsB != 0)
                $correct=false;
        }
        break;
    }
    if ($pointsA == $pointsB)
        $correct=false;
    if ($pointsA > $pointsB)
        $winsA++;
    else
        $winsB++;

}
if (!($winsA == 3 || $winsB == 3))
    $correct=false;
if ($winsA > $winsB)
    $winner = "1";
else $winner = "2";
if ($winsA == $winsB)
    $correct=false;
if ($correct) {
    for ($i = 1; $i <= 5; $i++) {
        $pointsA = $_POST["set" . $i . "A"];
        $pointsB = $_POST["set" . $i . "B"];
        pg_query($link, "INSERT INTO set
        VALUES(nextval('set_id_seq1'::regclass),$pointsA,$pointsB,$match)");
    }
    echo "<h3> Sety zostały dodane </h3>";
} else {
    echo "<h3>Niepoprawne wyniki setów</h3>";
}
pg_close($link);

echo "<a href=\"../organisatorPage.php\"> Wroc</a>";
?>