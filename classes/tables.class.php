<?php
class SQLTable extends DB {
  public function load($sqlName, $parm) {
    $sql = SQL::getSQL($sqlName, $parm);
    if (!isset($sql)) die('Invalid SQL Name: ' . $sqlName);
    $rs = $this->select($sql);

    $sql_select = '';
    foreach ($rs As $r) $sql_select = $r['Statement'];

    $sql_select = SQL::replaceParameters($sql_select, $parm);
    if (!isset($sql_select)) die('Invalid SQL statement: ' . $sql_select);

    if (DEBUG_FLAG == true) echo '...Statement (' . $sqlName . '): ' . $sql_select . '<br/>';

    return $this->select($sql_select);
  }

  private function getStatement($SQLName, $arr) {
    $sql_temp = SQL::getSQL($SQLName);
    if (!isset($sql_temp)) die('Invalid SQL Name: ' . $SQLName);
    $rs = $this->select($sql_temp);

    $sql_statement = '';
    foreach ($rs As $r) $sql_statement = $r['Statement'];

    $statement = SQL::replaceParameters($sql_statement, $arr);
    if (!isset($statement)) die('Invalid SQL statement: ' . $statement);

    return $statement;
  }

  public function execute($name, $parm) {
    $sql = $this->getStatement($name, $parm);
    if (DEBUG_FLAG == true) echo '...Statement (' . $name . '): ' . $sql . '<br/>';
    return DB::execute($sql);
  }

  public function loadTranslate($sqlName, $parm) {
    $rows = $this->load($sqlName, $parm);
    $tempDescr = '';
    foreach ($rows as $row) $tempDescr = $row['LongName'];
    return $tempDescr;
  }
}
?>
