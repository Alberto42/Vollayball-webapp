<html>
<head>
    <title>Mecze druzyny</title>
</head>
<body>

<?php
include '../utils.php';
connect();
$name = $_POST["imie"];
$surname = $_POST["nazwisko"];
$result = pg_query($link,
    "
    WITH sklady_zawierajace_zawodnika AS (SELECT id_sklad
    FROM zawodnik_sklad
    JOIN zawodnik ON zawodnik_sklad.id_zawodnik = zawodnik.id
    WHERE zawodnik.imie = '$name' AND zawodnik.nazwisko = '$surname')

    SELECT druzyna1.nazwa nazwa1,druzyna2.nazwa nazwa2, druzynaZwyciezka.nazwa zwyciezca, mecz.id id
    FROM mecz
    JOIN sklad sklad1 ON sklad1.id = mecz.sklad_1
    JOIN sklad sklad2 ON sklad2.id = mecz.sklad_2
    JOIN druzyna druzyna1 ON druzyna1.id = sklad1.druzyna
    JOIN druzyna druzyna2 ON druzyna2.id = sklad2.druzyna
    LEFT JOIN druzyna druzynaZwyciezka ON druzynaZwyciezka.id = mecz.zwyciezca
    WHERE
        sklad_1 IN (SELECT * FROM sklady_zawierajace_zawodnika)
      OR
        sklad_2 IN (SELECT * FROM sklady_zawierajace_zawodnika)"
);
$numrows = pg_numrows($result);
include 'result.php';
?>
</body>
</html>