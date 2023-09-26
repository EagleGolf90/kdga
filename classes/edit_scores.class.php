<?php
class EditScores {
  private $sqlTable;
  private $fullName;
  private $organization;

  public function __construct() { $this->sqlTable = new SQLTable(); }

  public function getFullName() { return $this->fullName; }
  public function getOrganization() { return $this->organization; }

  public function getPlayers($roundPlayed) { return $this->sqlTable->load('loadPlayers', array($roundPlayed)); }

  public function getPlayersScores($playerID, $roundPlayed) {
    $rows = $this->sqlTable->load('getPlayersName', array($playerID));
    foreach ($rows as $row) {
      $this->fullName = $row['LastName'] . ', ' . $row['FirstName'];
      $this->organization = $row['Organization'];
    }
    return $this->sqlTable->load('loadPlayersScores', array($playerID, $roundPlayed));
  }

  public function updateScores() {
    $parm = array($_POST['playerID'], $_POST['roundPlayed'], $_POST['holeNumber'], $_POST['scores']);
    $ret = $this->sqlTable->execute('updatePlayersScore', $parm);
  }
}
?>
