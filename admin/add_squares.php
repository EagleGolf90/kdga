<?php
include('../preload.php');

$sqlTable = new SQLTable();

$busUnit = 'MDGA';
$yearPick = 2022;
$eventType = 1;
$poolNumber = 2;

echo 'Business Unit: ' . $busUnit . '<br/>';
echo 'Year Pick: ' . $yearPick . '<br/>';
echo 'Event Type: ' . $eventType . '<br/>';
echo 'Pool Number: ' . $poolNumber . '<br/><br/>';

for ($quarter = 1; $quarter <= 4; $quarter++) {
  echo '<u>Quarter ' . $quarter . '</u><br/>';
  for ($x = 0; $x < 10; $x++) {
    $parm = array($busUnit, $yearPick, $eventType, $poolNumber, 'LA', $quarter, $x, 0);
    $ret = $sqlTable->execute(INSERT . SQUARES . GRID . DRAW, $parm);
    echo '*** Left Area Column ' . $x . '<br/>';

    $parm = array($busUnit, $yearPick, $eventType, $poolNumber, 'TA', $quarter, $x, 0);
    $ret = $sqlTable->execute(INSERT . SQUARES . GRID . DRAW, $parm);
    echo '*** Top Area Column ' . $x . '<br/>';
  }
  echo '<br/>';
}

echo '*** Add Squares successful ***<br/>';
?>
