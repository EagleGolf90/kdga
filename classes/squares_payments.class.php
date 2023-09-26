<?php
include(INCLUDES . 'constants.php');

class SquaresPayments {
  private $sqlTable;
  private $firstName;
  private $lastName;
  private $totalSquares;
  private $yearPick;
  private $eventType;
  private $poolNumber;
  private $eventTitle;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->setup();
  }

  public function __destruct() { unset($this->sqlTable); }

  public function getYearPick() { return $this->yearPick; }
  public function getEventType() { return $this->eventType; }
  public function getPoolNumber() { return $this->poolNumber; }
  public function getEventTitle() { return $this->eventTitle; }
  public function getName() { return $this->firstName . ' ' . $this->lastName; }
  public function getTotalSquares() { return $this->totalSquares; }

  private function setup() {
    $rs = $this->sqlTable->load(LOAD . PAYMENT_TITLE, array());
    $this->eventTitle = "Payments";
    foreach ($rs As $r) {
      $this->yearPick = $r['YearPick'];
      $this->eventType = $r['EventType'];
      $this->poolNumber = $r['PoolNbr'];
      $this->eventTitle = $r['EventDescription'];
    }
  }

  public function getInfo() {
    $parm = array(BUS_UNIT, $_GET['id']);
    $rows = $this->sqlTable->load(LOAD . PARTICIPANTS, $parm);

    foreach ($rows As $row) {
      $this->firstName = $row['FirstName'];
      $this->lastName = $row['LastName'];
    }
  }

  public function getOwnSquares($personID) {
    $tempSquares = '';
    $parm = array(BUS_UNIT, $personID);
    $rs = $this->sqlTable->load(LOAD . PEOPLE_PICKS, $parm);

    foreach ($rs As $r) {
      if ($tempSquares != '') { $tempSquares .= ', '; }
      $tempSquares .= $r['SquareNbr'];
      $this->totalSquares += 1;
    }

    return $tempSquares;
  }

  public function loadPayments() {
    $this->totalSquares = 0;
    $parm = array($this->yearPick, $this->eventType, $this->poolNumber);
    return $this->sqlTable->load(LOAD . PAYMENTS, $parm);
  }

  public function loadNames() {
    $parm = array(BUS_UNIT, $this->yearPick, $this->eventType, $this->poolNumber);
    return $this->sqlTable->load(LOAD . NAMES, $parm);
  }
}
?>
