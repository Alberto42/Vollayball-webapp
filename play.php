<?php
$druzyna1 = $_GET['druzyna1'];
$druzyna2 = $_GET['druzyna2'];
$match = $_GET["mecz"];
echo "<h3> $druzyna1 vs $druzyna2 </h3>
    <form method=\"post\" action=\"addSets.php?mecz=$match\">"
?>
    1 set -
    <input type="number" name="set1A"/> :
    <input type="number" name="set1B"/><br/>
    2 set -
    <input type="number" name="set2A"/> :
    <input type="number" name="set2B"/><br/>
    3 set -
    <input type="number" name="set3A"/> :
    <input type="number" name="set3B"/><br/>
    4 set -
    <input type="number" name="set4A"/> :
    <input type="number" name="set4B"/><br/>
    5 set -
    <input type="number" name="set5A"/> :
    <input type="number" name="set5B"/><br/>
    <input type="submit" value="Rozegraj"/>
</form>
