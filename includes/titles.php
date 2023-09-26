<?php
/*
 * Program File: titles.php
 * Author......: Brian Timberlake
 * Date Created: October 18, 2021
 * Description.: This program is to get a title based on a page.
 */
class Titles {
  private $sqlTable;

  public function __construct() { $this->sqlTable = new SQLTable(); }

  public function getPageTitle($pageName) {
    $rows = $this->sqlTable->load('getTitles', array($pageName));
    foreach ($rows as $row) return $row['PageTitle'];
    return '';
  }

  public function getProgramNames($title) {
    $rows = $this->sqlTable->load('getProgram', array($title));
    foreach ($rows as $row) return $row['ProgramName'];
    return '';
  }
}
?>
