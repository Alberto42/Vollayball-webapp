<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 04.01.18
 * Time: 13:36
 */
include '../../utils.php';
connect();
pg_query($link,"UPDATE dostepnosczgloszen SET dostepne = FALSE");
pg_close($link);
echo "<h3>Zgłoszenia zostały zamknięte</h3>";