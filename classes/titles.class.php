<?php
define('GET_TITLE', 'getTitles');
define('GET_PROGRAM', 'getProgram');

class Titles {
  private $sqlTable;

  public function __construct() {
    $this->sqlTable = new SQLTable();
  }

  public function getPageTitle($pageName) {
    $parm = array($pageName);
    $rows = $this->sqlTable->load(GET_TITLE, $parm);
    $pageTitle = '';
    foreach ($rows as $row) $pageTitle = $row['PageTitle'];
    return $pageTitle;
  }

  public function getProgramNames($title) {
    $parm = array($title);
    $rows = $this->sqlTable->load(GET_PROGRAM, $parm);
    $programName = '';
    foreach ($rows as $row) $programName = $row['ProgramName'];
    return $programName;
  }
}
?>
