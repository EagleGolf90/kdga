<?php
class GolfSetup {
  private $sqlTable;
  private $courseID;
  private $nbrOfGroups;
  private $startTee;
  private $oddMinutes;
  private $evenMinutes;
  private $shotgun;
  private $startHole;
  private $annual;
  private $yearPlayed;
  private $monthPlayed;
  private $roundPlayed;
  private $startDate;
  private $nbrOfRounds;
  private $doublePar;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->load();
  }

  public function __destruct() { $this->sqlTable = null; }

  public function getAnnual() { return $this->annual; }
  public function getNbrOfGroups() { return $this->nbrOfGroups; }
  public function getStartTee() { return $this->startTee; }
  public function getYearPlayed() { return $this->yearPlayed; }
  public function getMonthPlayed() { return $this->monthPlayed; }
  public function getStartHole() { return $this->startHole; }
  public function getOddMinutes() { return $this->oddMinutes; }
  public function getEvenMinutes() { return $this->evenMinutes; }
  public function getStartDate() { return $this->startDate; }
  public function NbrOfRounds() { return $this->nbrOfRounds; }
  public function getShotgun() { return $this->shotgun; }
  public function getDoublePar() { return $this->doublePar; }

  public function update() {
    $parm = array(BUS_UNIT);
    $ret = $this->sqlTable->execute('updateSetup', $parm);
  }

  private function selectCourse() {
    $rows = $this->sqlTable->load('getCourses', array());
    foreach ($rows as $row) return $row['CourseID'];
    return 0;
  }

  public function printAllFields() {
    echo $this->annual . '<br/>';
    echo $this->nbrOfGroups . '<br/>';
    echo $this->startTee . '<br/>';
    echo $this->oddMinutes . '<br/>';
    echo $this->evenMinutes . '<br/>';
    echo $this->shotgun . '<br/>';
    echo $this->startHole . '<br/>';
    echo $this->yearPlayed . '<br/>';
    echo $this->monthPlayed . '<br/>';
    echo $this->startDate . '<br/>';
    echo $this->nbrOfRounds . '<br/>';
    echo $this->doublePar . '<br/>';
  }

  private function load() {
    $rows = $this->sqlTable->load('loadSetup', array(BUS_UNIT));

    foreach ($rows as $row) {
      $this->nbrOfGroups = $row['NumberOfGroups'];
      $this->startTee = $row['StartTeeTime'];
      $this->oddMinutes = $row['OddMinutes'];
      $this->evenMinutes = $row['EvenMinutes'];
      $this->shotgun = $row['Shotgun'];
      $this->startHole = $row['StartingHole'];
      $this->annual = $row['Annual'];
      $this->yearPlayed = $row['YearPlayed'];
      $this->monthPlayed = $row['MonthPlayed'];
      $this->roundPlayed = $row['RoundPlayed'];
      $this->startDate = $row['StartDate'];
      $this->nbrOfRounds = $row['NumberOfRounds'];
      $this->doublePar = $row['DoublePar'];
    }
    $this->courseID = $this->selectCourse();
  }
}
?>
