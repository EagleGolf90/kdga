<?php
class Participant {
  private $sqlTable;
  
  public function __construct() {
    $this->sqlTable = new SQLTable();
  }
  
  public function GetLists($value) {
    return $this->sqlTable->load('GetParticipants', array($value));
  }
}
?>
