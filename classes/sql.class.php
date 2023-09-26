<?php
define('NUMBER_OF_LETTERS', 26);

class SQL {
  public function getSQL($sqlname) {
    return 'SELECT * FROM sql_statements WHERE SQLName = "' . $sqlname . '"';
  }

  public function replaceParameters($sql_select, $parm) {
    $sql_temp = $sql_select;

    $totalArrays = count($parm);
    $totalLoops = intval($totalArrays / NUMBER_OF_LETTERS);

    if ($totalArrays % NUMBER_OF_LETTERS == 0) {
      $totalLoops += 0;
    } else {
      $totalLoops += 1;
    }
    $initialCount = 0;

    for ($b = 0; $b < $totalLoops; $b++) {
      for ($a = 0; $a < NUMBER_OF_LETTERS; $a++) {
        if ($initialCount < $totalArrays) {
          $parameterLetter = ':' . chr(97+$a) . ($b+1);
          $sql_temp = str_replace($parameterLetter, $parm[$initialCount], $sql_temp);
        }
        $initialCount += 1;
      }
    }

    return $sql_temp;
  }
}
?>
