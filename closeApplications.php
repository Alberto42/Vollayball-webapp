<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 04.01.18
 * Time: 13:36
 */
$link = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
pg_query($link,"UPDATE dostepnosczgloszen SET dostepne = FALSE");