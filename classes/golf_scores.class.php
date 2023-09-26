<?php
class GolfScores {
  private $sqlTable;
  private $courseInfo;
  private $courseDetails;
  private $players;
  private $roundPlayed;
  private $roundID;
  private $courseID;
  private $finalCut = 0;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->courseInfo = array();
    $this->courseDetails = array();
    $this->loadFinalCut();
  }

  public function getRoundID() { return $this->roundID; }
  public function isTeamFinalCut($team_cut) { return ($team_cut == $this->finalCut); }
  public function isSecondRowOrMore($x) { return ($x > 0); }
  public function separator() { return '<hr/>'; }

  public function printGolferName($row) {
    echo '<tr><td>' . $row['LastName'] . ', ' . $row['FirstName'] . '</td><td>' . ($row['TotalScore'] == '' ? '&nbsp;' : $row['TotalScore']) . '</td></tr>';
  }

  public function getCourseInfo($roundPlayed)
  {
    $this->roundPlayed = $roundPlayed;
    $this->loadCourseInfo();
    return $this->courseInfo;
  }

  public function getCourseDetails()
  {
    $this->loadCourseDetails();
    return $this->courseDetails;
  }

  public function loadRoundPlayed() { return $this->sqlTable->load('loadRoundPlayed', array()); }

  public function getRoundPlayed($round) {
    if ($round == 0) {
      $parm = array('(select RoundPlayed from golfsetup)');
    } else {
      $parm = array($round);
    }
    $rs = $this->sqlTable->load('getRoundInfo', $parm);
    $roundPlayed = 0;
    foreach ($rs as $r) {
      $roundPlayed = $r['RoundPlayed'];
      $this->courseID = $r['CourseID'];
      $this->roundID = $r['RoundID'];
    }
    return $roundPlayed;
  }

  public function getTeamScores() {
    $team_scores = array();
    $teams_row = $this->sqlTable->load('loadOrganizations', array());
    foreach ($teams_row as $team_row) {
      $teams_total = 0;
      $teams = $this->sqlTable->load('loadTeamsScores', array($team_row['FieldValue']));
      foreach ($teams as $team) $teams_total += $team['TotalScore'];
      $team_scores[] = array($team_row['FieldValue'], $team_row['LongName'], $teams_total);
    }
    return $team_scores;
  }

  public function getPlayers($roundPlayed)
  {
    $this->roundPlayed = $roundPlayed;
    $this->loadRoundID();
    $this->loadListOfPlayers('loadListOfPlayers', array($roundPlayed));
    return $this->players;
  }

  public function getGroups($roundPlayed, $group) {
    $this->roundPlayed = $roundPlayed;
    $this->loadRoundID();
    $this->loadListOfPlayers('loadPlayersGroup', array($roundPlayed, $group));
    return $this->players;
  }

  public function getSkinsParticipants() { return $this->sqlTable->load('loadSkinsParticipants', array()); }
  public function displaySkinsParticipants() { return $this->sqlTable->load('displaySkinsParticipants', array()); }

  public function getParticipants() { return $this->sqlTable->load('loadParticipants', array()); }
  public function displayParticipants() { return $this->sqlTable->load('displayParticipants', array()); }

  public function displayContacts() { return $this->sqlTable->load('displayContacts', array()); }

  public function getPairings($roundPlayed) { return $this->sqlTable->load('loadPairings', array($roundPlayed)); }
  public function displayPairings($roundPlayed) { return $this->sqlTable->load('displayPairings', array($roundPlayed)); }

  public function getRounds() { return $this->sqlTable->load('loadRounds', array()); }
  public function getLeaderboard() { return $this->sqlTable->load('loadLeaderboard', array()); }
  public function getTwoDayLeaderboard() { return $this->sqlTable->load('loadTwoDayLeaderboard', array()); }
  public function loadNetScoreLeaderboard() { return $this->sqlTable->load('loadNetScoreLeaderboard', array()); }
  public function checkSkins($roundPlayed) { return $this->sqlTable->load('checkSkins', array($roundPlayed)); }

  public function addScores() {
    $players = $_POST['player'];
    $round_played = $_POST['roundPlayed'];
    $round_id = $_POST['roundID'];

    foreach ($players as $key => $value) {
      $player_id = $value;

      $tag_name = $this->concatenateZeros($value);
      $score_id = $_POST['scores' . $tag_name];

      $hole = 1;
      $totalScore = 0;

      foreach ($score_id as $key => $value) {
        $totalScore += $value;
        $parm = array($player_id, $round_played, $round_id, $hole, $value);
        $ret = $this->sqlTable->execute('addScores', $parm);
        $hole++;
      }

      $parm = array($round_played, $player_id, $totalScore);
      $ret = $this->sqlTable->execute('updateScores', $parm);
      if ($ret == 1) echo 'Player ' . $player_id . ' scores ' . $totalScore . ' is submitted.<br/>';
    }
  }

  public function addContacts() { $ret = $this->sqlTable->execute('addNames', array($this->generateID(), $_POST['firstName'], $_POST['lastName'], $_POST['org_name'])); }
  public function deleteContacts($playerID) { $this->sqlTable->execute('deleteContacts', array($playerID)); }

  public function addSkins() { $ret = $this->sqlTable->execute('addSkins', array($_POST['roundPlayed'], $_POST['playerID'], ($_POST['paid'] == 1 ? 'Y' : 'N'), 5.00)); }
  public function deleteSkins($roundPlayed, $playerID) { $this->sqlTable->execute('deleteSkinsParticipants', array($roundPlayed, $playerID)); }

  private function addParticipantsRound($roundID) {
    $rows = $this->sqlTable->load('selectRoundPlayed', array($roundID));
    $roundPlayed = 1;
    foreach ($rows as $row) $roundPlayed = $row['RoundPlayed'];
    $ret = $this->sqlTable->execute('addParticipants', array($roundPlayed, $_POST['playerID']));
  }

  public function getRedirectLink($name, $roundPlayed) {
    $rs = $this->sqlTable->load('loadRedirectLink', array($name));
    $link = '';
    $round_played = 'N';
    foreach ($rs as $r) {
      $link = $r['url_link'];
      $round_played = $r['round_played'];
    }
    if ($round_played == 'Y') $link .= '?roundPlayed=' . $roundPlayed;
    return $link;
  }

  public function addParticipants()
  {
    $this->addParticipantsRound(1);
    if ($_POST['player_choice'] == '2') $this->addParticipantsRound(2);
    $ret = $this->sqlTable->execute('addPlayersChoice', array($_POST['playerID'], $_POST['player_choice']));
  }

  public function deleteParticipants($playerID) {
    $this->sqlTable->execute('deleteParticipant', array($playerID));
    $this->sqlTable->execute('deletePlayersChoice', array($playerID));
  }

  public function addPairings() { $ret = $this->sqlTable->execute('addPairings', array($_POST['roundPlayed'], 1, strtoupper($_POST['groupID']), $_POST['playerID'])); }
  public function deletePairings($roundPlayed, $group) { return $this->sqlTable->execute('deletePairings', array($roundPlayed, $group)); }

  private function countPlayers() {
    $rows = $this->sqlTable->load('countPlayers', array());
    $numberOfRows = 0;
    foreach ($rows as $row) $numberOfRows = $row['Total'];
    return $numberOfRows;
  }

  public function calculateGroupSize() {
    $totalGolfers = $this->countPlayers();
    $golfersInGroup = 4;
    $groupSizeRemainder = fmod($totalGolfers, $golfersInGroup);
    $groupSize = intval($totalGolfers / $golfersInGroup);
    if ($groupSizeRemainder > 0) $groupSize += 1;
    return $groupSize;
  }

  public function modifySetup() { return $this->sqlTable->execute('updateSetup', array(BUS_UNIT, $_POST['final_cut'])); }

  public function getAllScores($roundPlayed) { return $this->sqlTable->load('loadAllScores', array($roundPlayed)); }

  private function concatenateZeros($value) {
    $temp_value = '';
    if ($value < 100) $temp_value = '0' . $value;
    if ($value < 10) $temp_value = '00' . $value;
    return $temp_value;
  }

  private function loadFinalCut() {
    $rows = $this->sqlTable->load('loadFinalCut', array());
    foreach ($rows as $row) $this->finalCut = $row['FinalCut'];
  }

  private function loadCourseInfo() {
    $rows = $this->sqlTable->load('loadCourseInfo', array($this->roundPlayed));
    foreach ($rows as $row) {
      $this->courseID = $row['CourseID'];

      $this->courseInfo[] = array(
                 $row['CourseID'],
                 $row['CourseName'],
                 $row['DatePlayed'],
                 $row['City'],
                 $row['State'],
                 $row['CourseRating'],
                 $row['SlopeRating']);
    }
  }

  private function loadCourseDetails() {
    $rows = $this->sqlTable->load('loadCourseDetails', array($this->courseID));
    foreach ($rows as $row) $this->courseDetails[] = array($row['Par'], $row['Yards'], $row['Handicap']);
  }

  private function loadRoundID() {
    $rows = $this->sqlTable->load('getRoundInfo', array($this->roundPlayed));
    foreach ($rows as $row) $this->roundID = $row['RoundID'];
  }

  private function loadListOfPlayers($sql_name, $parm) {
    $this->players = array();
    $rows = $this->sqlTable->load($sql_name, $parm);
    foreach ($rows as $row) $this->players[] = array($row['GroupID'], $row['FullName'], $row['PlayerID'], $row['TotalScore']);
  }

  private function generateID() {
    $rs = $this->sqlTable->load('getUniqueID', array(BUS_UNIT, 'PlayerID'));

    $id = 1;
    foreach ($rs As $r) $id = $r['UniqueID'] + 1;

    $ret = $this->sqlTable->execute('updateUniqueID', array(BUS_UNIT, 'PlayerID', $id));

    return $id;
  }
}
?>