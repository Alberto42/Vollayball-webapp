<?php

$futureMatches = pg_query($link, "
SELECT druzyna1.nazwa nazwa1, druzyna2.nazwa nazwa2, mecz.id id, 
mecz.sklad_1 sklad1id, mecz.sklad_2 sklad2id 
FROM mecz
JOIN sklad sklad1 ON sklad1.id = mecz.sklad_1
JOIN sklad sklad2 ON sklad2.id = mecz.sklad_2
JOIN druzyna druzyna1 ON druzyna1.id = sklad1.druzyna
JOIN druzyna druzyna2 ON druzyna2.id = sklad2.druzyna
WHERE mecz.zwyciezca = 0
");

$numrows = pg_numrows($futureMatches);

?>
<h2 align=center>Nierozegrane mecze:</h2>

<table border="1" align=center>
    <tr>
        <th>Pierwsza drużyna</th>
        <th>Druga drużyna</th>
        <th>Rozegraj</th>
    </tr>
    <?php

    for ($ri = 0; $ri < $numrows; $ri++) {
        $row = pg_fetch_array($futureMatches, $ri);
        $match = $row["id"];
        $druzyna1 = $row["nazwa1"];
        $druzyna2 = $row["nazwa2"];
        $sklad1Id = $row["sklad1id"];
        $sklad2Id = $row["sklad2id"];

        $sklad1Count = pg_fetch_array(
            pg_query($link,
                "SELECT COUNT(*) n 
                    FROM zawodnik_sklad WHERE id_sklad=$sklad1Id"), 0)["n"];
        $sklad2Count = pg_fetch_array(
            pg_query($link,
                "SELECT COUNT(*) n 
                    FROM zawodnik_sklad WHERE id_sklad=$sklad2Id"), 0)["n"];

        $linkAddSklad1 = "<br/> <a href=\"subset.php?druzyna=$druzyna1&skladId=$sklad1Id\">Ustal sklad</a>";
        $linkAddSklad2 = "<br/><a href=\"subset.php?druzyna=$druzyna2&skladId=$sklad2Id\">Ustal sklad</a>";

        if ($sklad1Count > 0)
            $linkAddSklad1 = "";
        if ($sklad2Count > 0)
            $linkAddSklad2 = "";
        echo
            "<tr>\n
                <td>"
            . $druzyna1 .
            $linkAddSklad1 . "
                </td>
                <td>"
            . $druzyna2 .
            $linkAddSklad2 . "
                </td>
                <td> 
                    <a href=\"play.php?mecz=$match&druzyna1=$druzyna1&druzyna2=$druzyna2\">
                        Rozegraj
                    </a> 
                </td>

            </tr>";
    }
    pg_close($link);
    ?>
</table>