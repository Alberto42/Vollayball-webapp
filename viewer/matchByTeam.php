<html>
<head>
    <title>Mecze druzyny</title>
</head>
<body>

<?php
include '../utils.php';
connect();
$team = $_POST["druzyna"];
$result = pg_query($link,
    "SELECT druzyna1.nazwa nazwa1,
          druzyna2.nazwa nazwa2,
           druzynaZwyciezka.nazwa zwyciezca, mecz.id id 
FROM mecz
JOIN sklad sklad1 ON sklad1.id = mecz.sklad_1
JOIN sklad sklad2 ON sklad2.id = mecz.sklad_2
JOIN druzyna druzyna1 ON druzyna1.id = sklad1.druzyna
JOIN druzyna druzyna2 ON druzyna2.id = sklad2.druzyna
LEFT JOIN druzyna druzynaZwyciezka ON druzynaZwyciezka.id = mecz.zwyciezca
WHERE druzyna1.nazwa = '$team' OR druzyna2.nazwa = '$team'");
$numrows = pg_numrows($result);
?>
<?php include 'result.php';?>
</body>
</html>