<?php
class Players {
  private $playerID = 0;
  private $firstName;
  private $lastName;
  private $scores;

  public function __construct() { $this->scores = array(); }

  public function getPlayerID() { return $this->_playerID; }

  public function getFirstName() { return $this->firstName; }
  public function setFirstName($firstName) {
    $this->playerID += 1;
    $this->firstName = $firstName;
  }

  public function setName($firstName, $lastName) {
    $this->playerID += 1;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
  }

  public function getLastName() { return $this->lastName; }
  public function setLastName($lastName) { $this->lastName = $lastName; }

  public function setScores($scores) { $this->scores = $scores; }
  public function getScores() { return $this->scores; }

  public function printScores() {
    echo 'Player ID: ' . $this->playerID . '<br/>';
    echo 'Name: ' . $this->firstName . ' ' . $this->lastName . '<br/>';
    echo 'Scores<hr>';
    for ($x = 0; $x < sizeof($this->scores); $x++) {
      echo 'Hole ' . ($x+1) . ': ' . $this->scores[$x] . '<br/>' . "\n";
    }
  }
}
?>
