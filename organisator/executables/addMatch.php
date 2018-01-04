<?php
include '../../utils.php';
$teamA = $_POST["teamA"];
$teamB = $_POST["teamB"];
if ($teamA != $teamB) {

    connect();
    pg_query($link, "CREATE OR REPLACE FUNCTION addMatch()
    RETURNS VOID AS $$
    DECLARE
      idSklad1 INTEGER;
      idSklad2 INTEGER;
      idDruzyna1 INTEGER;
      idDruzyna2 INTEGER;
    BEGIN
      idSklad1 := (SELECT nextval('sklad_id_seq1'::regclass) FROM sklad_id_seq1);
      idSklad2 := (SELECT nextval('sklad_id_seq1'::regclass) FROM sklad_id_seq1);
      idDruzyna1 := (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = '$teamA');
      idDruzyna2 := (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = '$teamB');
      INSERT INTO sklad
      VALUES(idSklad1,idDruzyna1);
      INSERT INTO sklad
      VALUES(idSklad2,idDruzyna2);
      INSERT INTO mecz
      VALUES(nextval('mecz_id_seq1'::regclass),idSklad1,idSklad2,0);
    END;
    $$ LANGUAGE plpgsql;
 SELECT addMatch();");
    pg_close($link);

    echo "<h3>Dodano mecz pomiędzy drużyną $teamA a drużyną $teamB</h3>";
} else {
    echo "<h3>Nie mozna dodac meczu pomiędzy takimi samymi drużynami</h3>";
}
?>