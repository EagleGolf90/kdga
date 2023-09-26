<?php
/*
 * Program Name..: squares.class.php
 * Author........: Brian Timberlake
 * Date Created..: September 9, 2019
 */
include(INCLUDES . 'constants.php');

class Squares {
  private $sqlTable;
  private $yearPick;
  private $eventType;
  private $poolNumber;
  private $eventTitle;
  private $formulaType;
  private $topTeam;
  private $leftTeam;
  private $topSquares;
  private $leftSquares;
  private $listPick;
  private $businessUnit;
  private $cost;
  private $maxSeqNo;
  private $fundDescription;
  private $amount;
  private $giveAmount;
  private $keepAmount;
  private $boxes;
  private $boxSelected;
  private $boxesSelected;
  private $boxExcluded;
  private $selectBoxes;
  private $openForPublic;
  private $showNames;
  private $idLabel;
  private $saved;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->openForPublic = false;
    if (DEBUG_FLAG) echo 'In Squares constructor<br/>';
    $this->resetVariables();
    $this->loadSquares();
  }

  public function __destruct() {
    $this->listPick = null;
    $this->topTeam = null;
    $this->leftTeam = null;
    $this->topSquares = null;
    $this->leftSquares = null;
    $this->poolNumber = null;
    unset($this->sqlTable);
  }

  private function resetVariables() {
    $this->boxSelected = '';
    $this->topSquares = array();
    $this->leftSquares = array();
    $this->topTeam = '';
    $this->leftTeam = '';
    $this->boxExcluded = '';
  }

  private function loadSquares() {
    if (DEBUG_FLAG) echo 'In loadSquares before getCurrentEvent()<br/>';

    $this->getCurrentEvent();
    if ($this->openForPublic == true) {
      $this->displayTeams();
      $this->teamSquares();
      $this->populatePicks();
    }
  }

  public function openForPublic() { return $this->openForPublic; }

  private function getCurrentEvent() {
    if (DEBUG_FLAG) echo 'In getCurrentEvent()<br/>SQLName: ' . LOAD . CURRENT . EVENTS . '<br/>';
    $rows = $this->sqlTable->load(LOAD . CURRENT . EVENTS, array());

    foreach ($rows As $row) {
      $this->openForPublic = true;
      $this->businessUnit = $row['BusinessUnit'];
      $this->yearPick = $row['YearPick'];
      define('YEAR_PICK', $row['YearPick']);
      $this->poolNumber = $row['PoolNbr'];
      define('POOL_NBR', $row['PoolNbr']);
      $this->eventType = $row['EventType'];
      $this->eventTitle = $row['Description'];
      $this->cost = $row['Cost'];
      $this->fundDescription = $row['FundDesc'];
      $this->amount = $row['Amount'];
      $total = $this->cost * 100;
      $this->giveAmount = ($total * ($row['GivePercent']/100));
      $this->keepAmount = ($total * ($row['KeepPercent']/100));
      $this->formulaType = $row['Formula'];
      define('FORMULA', $row['Formula']);
      $this->showNames = $row['ShowNames'];
    }
  }

  public function setBoxes($boxes) {
    $this->boxes = $boxes;
    $this->extractBoxesSelected();
  }

  public function setYearPick($yr) { $this->yearPick = $yr; }
  public function setEventType($type) { $this->eventType = $type; }
  public function setPoolNumber($pool) { $this->poolNumber = $pool; }

  public function extractBoxesSelected() {
    for ($x = 0; $x < count($this->boxes); $x++) {
      if ($x > 0) $this->boxSelected .= ', ';
      $this->boxSelected .= $this->boxes[$x];
    }
  }

  public function getShowNames() { return $this->showNames; }
  public function getBoxSelected() { return $this->selectBoxes; }
  public function getBoxExcluded() { return $this->boxExcluded; }
  public function getBoxLabel() { return ($this->howManyBoxesExcluded() > 1) ? 'boxes' : 'box'; }
  public function countTotalExcluded() { return ($this->boxExcluded != ''); }
  public function getPoolNumber() {	return $this->poolNumber; }
  public function getBusinessUnit() { return $this->businessUnit; }
  public function getYearPick() { return $this->yearPick; }
  public function getEventType() { return $this->eventType; }
  public function getFundDesc() { return $this->fundDescription; }
  public function getGiveAmount() { return $this->giveAmount; }
  public function getKeepAmount() { return $this->keepAmount; }
  public function getCost() { return $this->cost; }
  public function howManyBoxesSelected() { return count(comma_separated_to_array($this->boxSelected)); }
  public function howManyBoxesExcluded() { return count(comma_separated_to_array($this->boxExcluded)); }
  public function getSavedSquares() { return $this->saved; }

  public function getEventTitle() {
    $tempTitle = '';
    $tempTitle = str_replace(":1", $this->yearPick, $this->eventTitle);
    return $tempTitle;
  }

  public function getInstructions() {
    $parm = array($this->yearPick, $this->eventType, $this->poolNumber);
    return $this->sqlTable->load(LOAD . INSTRUCTIONS, $parm);
  }

  private function populatePicks() {
    if (DEBUG_FLAG) echo 'In populatePicks()<br/>before SQLName: ' . LOAD . POPULATE_PICKS . '<br/>';
    $parm = array($this->yearPick, $this->poolNumber);
    $picks = $this->sqlTable->load(LOAD . POPULATE_PICKS, $parm);
    if (DEBUG_FLAG) echo 'In populatePicks()<br/>after SQLName: ' . LOAD . POPULATE_PICKS . '<br/>';

    $this->listPick = array('');
    foreach ($picks As $pick) $this->listPick[$pick['SquareNbr']] = array($pick['Initials'], $pick['FullName'], $pick['Paid']);
  }

  private function teamSquares() {
    if (DEBUG_FLAG) echo 'In teamSquares()<br/>before SQLName: ' . LOAD . TEAMS . SQUARES . '<br/>';
    $parm = array(BUS_UNIT, $this->yearPick, $this->eventType, $this->poolNumber);
    $rows = $this->sqlTable->load(LOAD . TEAMS . SQUARES, $parm);
    $y = 0;
    $z = 0;

    foreach ($rows As $row) {
      if ($row['Grid'] == 'LA') {
        $this->leftSquares[$y] = array($row['Quarter'], $row['Square'], $row['PickScore']);
        $y++;
      } else {
        $this->topSquares[$z] = array($row['Quarter'], $row['Square'], $row['PickScore']);
        $z++;
      }
    }
  }

  private function displayTeams() {
    if (DEBUG_FLAG) echo 'In displayTeams()<br/>before SQLName: ' . DISPLAY . TEAMS . '<br/>';
    $parm = array(BUS_UNIT, $this->yearPick, $this->eventType, $this->poolNumber);
    $rows = $this->sqlTable->load(DISPLAY . TEAMS, $parm);

    foreach ($rows As $row) {
      $this->topTeam = $row['TopGridTeam'];
      $this->leftTeam = $row['LeftGridTeam'];
    }
  }

  private function printCellTopBox($id, $value) {
?>
    <td class='tblock' id='<?php echo $id; ?>'><b><?php echo $this->showNames == 'Y' ? $value : ''; ?></b></td>
<?php
  }

  public function printNFLLeftBox() {
?>
    <tr>
      <td rowspan='11'><h2 class='rotate title'><?php echo $this->showNames == 'Y' ? $this->leftTeam : ''; ?></h2></td>
      <td class='blank' id='fourth'>Final</td>
      <td class='blank' id='third'>3rd</td>
      <td class='blank' id='second'>2nd</td>
      <td class='blank' id='first'>1st</td>
<?php
    // Top Squares
    for ($a = 0; $a < 10; $a++) {
      $id = 'ta' + ($a+1);
      echo $this->PrintCellTopBox($id, $this->topSquares[$a][2]);
    }
?>
    </tr>
<?php
  }

  private function printNFLTopBox() {
?>
    <tr><td></td><td colspan='14'><h2 class='title'><?php echo $this->showNames == 'Y' ? $this->topTeam : ''; ?></h2></td></tr>
<?php
  }

  private function quarterLabel($quarter) {
    $label = '';
    $this->idLabel = '';
    switch ($quarter) {
      case 1:
        $label = '1st';
        $this->idLabel = 'first';
        break;
      case 2:
        $label = '2nd';
        $this->idLabel = 'second';
        break;
      case 3:
        $label = '3rd';
        $this->idLabel = 'third';
        break;
      case 4:
        $label = 'Final';
        $this->idLabel = 'fourth';
        break;
    }
    return $label;
  }

  private function sectionLabel($quarter) {
    $label = '';
    switch ($quarter) {
      case 4:
        $label = 'Pending';
        break;
      case 3:
        $label = 'Taken';
        break;
      case 2:
        $label = 'Select';
        break;
    }
    return $label;
  }

  private function printEachQuarter($quarter) {
    $quarterLabel = $this->quarterLabel($quarter);
    $sectionLabel = $this->sectionLabel($quarter);
?>
    <tr>
      <td></td>
      <td colspan='3' class='blank <?php echo strtolower($sectionLabel) . 'Title'; ?>'><?php echo $sectionLabel . ($sectionLabel == 'Select' ? 'ed' : ''); ?></td>
      <td class='blank' id='<?php echo $this->idLabel; ?>'><?php echo $quarterLabel; ?></td>
<?php
for ($x = 0; $x < sizeof($this->topSquares); $x++) {
  if ($quarter == $this->topSquares[$x][0]) {
    $id = $quarter . '_' . ($x+1);
?>
      <td class='tblock' id='ta_<?php echo $id; ?>'><b><?php echo $this->showNames == 'Y' ? $this->topSquares[$x][2] : ''; ?></b></td>
<?php
  }
}
?>
    </tr>
<?php
  }

  private function printTopFourQuarters() {
    for ($y = 4; $y > 1; $y--) $this->printEachQuarter($y);
  }

  private function printBoxArea($id, $className, $value) {
?>
    <td class='<?php echo $className; ?>' id='<?php echo $id; ?>'><?php echo $value; ?></td>
<?php
  }

  private function printLeftArea($rowNumber) {
    for ($quarter = 4; $quarter > 0; $quarter--) {
      for ($a = 0; $a < sizeof($this->leftSquares); $a++) {
        if ($this->leftSquares[$a][0] == $quarter && $this->leftSquares[$a][1] == $rowNumber) {
          $squareBox = '<b>' . ($this->showNames == 'Y' ? $this->leftSquares[$a][2] : '') . '</b>';
          $id = 'la_' . ($rowNumber+1) . '_' . $quarter;
          $this->printBoxArea($id, 'sblock', $squareBox);
        }
      }
    }
  }

  private function getClassName($index) {
    if ($this->listPick[$index][0] == ' ') {
      if ($this->listPick[$index][2] == 'Y') {
        $class = $this->showNames == 'Y' ? 'available' : 'taken';
      } else {
        $class = 'pending';
      }
    } else {
      $class = 'available';
    }
    return $class;
  }

  private function getBoxNumber($index) {
    return $this->showNames == 'Y' ? $this->listPick[$index][1] : '<a href="#">' . strval($index) . '</a>';
  }

  private function printGridSquares() {
    $n = 0;
    $z = 0;
    for ($y = 0; $y < 10; $y++) {
?>
      <tr>
<?php
      for ($x = 1; $x <= 10; $x++) {
        if ($x == 1) $this->printLeftArea($y);
        $first = $x == 10 ? $y + 1 : $y;
        $second = $x == 10 ? 0 : $x;
        $attributeBoxNumber = 'b_' . $first . '_' . $second;
        $className = $this->getClassName($z+1) . ($this->showNames == 'Y' ? ' names' : '');
        $this->printBoxArea($attributeBoxNumber, $className, $this->getBoxNumber($z+1));
        $z += 1;
      }
?>
      </tr>
<?php
    }
  }

  private function printPrizesInfo() {
?>
    <tr>
      <td class="ctr instruction" colspan="5">
        1st Quarter = $150 / $25 (diamond)
      </td>
      <td class="ctr instruction" colspan="5">
        3rd Quarter = $250 / $40 (diamond)
      </td>
      <td class="ctr instruction" colspan="5">
        25% ($500) Proceeds to 75th MDGA / 58th MDLGA
      </td>
    </tr>
    <tr>
      <td class="ctr instruction" colspan="5">
        2nd Quarter = $200 / $35 (diamond)
      </td>
      <td class="ctr instruction" colspan="5">
        Final Score = $300 / $50 (diamond)
      </td>
      <td class="ctr instruction" colspan="5">
        $1500 to 20 WINNERS! <span class="support">THANK YOU FOR YOUR SUPPORT!</span>
      </td>
    </tr>
<?php
  }

  private function printInstructionButton() {
?>
    <tr>
      <td class="ctr" colspan="15"><button id="submitForm" class="btn btn-primary btn-lg">Ready to buy Squares</button><br/></td>
    </tr>
    <tr>
      <td class="ctr event" colspan="15">
        <h4><a href="<?php echo SQUARES_URL; ?>">Back to Instructions</a></h4>
      </td>
    </tr>
<?php
  }

  public function printSquares() {
?>
    <div class="container-fluid">
      <table class="table table-bordered table-hover" cellspacing="1" cellpadding="1">
<?php
    $this->printNFLTopBox();   // Top Row
    $this->printTopFourQuarters(); // Top Row Four Quarters
    $this->printNFLLeftBox();  // Left Column
    $this->printGridSquares(); // 100 Box Cells

    if ($this->showNames == 'N') {
      $this->printInstructionButton();
    } else {
      $this->printPrizesInfo();
    }
?>
    </table>
    <div id="boxSelected"></div>
  </div>
<?php
  }

  private function countTotalBoxes() { return count(comma_separated_to_array($_GET['box'])); }

  public function calculateAmounts($cashapp) {
    $howMany = $this->countTotalBoxes();
    $total = $this->cost * $howMany;
    //echo 'Since you buy ' . $howMany . ' square(s), you need to pay $' . $total . ' either cash, check or money order to ' . BUS_UNIT . '.';
    //echo '<br/>You must pay $' . $total . ' within 7 days OR you will lose ' . $howMany . ' square(s). NO EXCEPTIONS.';
    return 'Since you buy ' . $howMany . ' square(s), you need to pay $' . $total . ' to CashApp ' . $cashapp . ' by February 3.';
  }

  private function insertParticipant() {
    $sqlName = INSERT . PARTICIPANTS;
    $parm = array(BUS_UNIT, $this->personID, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR']);
    $ret = $this->sqlTable->execute($sqlName, $parm);
  }

  private function getUniqueID($uniqueFieldName) {
    $sqlName = GET . UNIQUE_ID;
    $parm = array(BUS_UNIT, $uniqueFieldName);
    $rows = $this->sqlTable->load($sqlName, $parm);

    $this->personID = 1;
    foreach ($rows As $row) $this->personID = $row['UniqueID'];
    $this->personID = $this->personID + 1;

    $sqlName = UPDATE . UNIQUE_ID;
    $parm = array(BUS_UNIT, $uniqueFieldName, $this->personID);
    $ret = $this->sqlTable->execute($sqlName, $parm);
  }

  private function insertPeoplePicks() {
    $sqlName = INSERT . PEOPLE_PICKS;
    for ($a = 1; $a <= sizeof($this->boxesSelected); $a++) {
      if ($this->boxesSelected[$a-1] > 0) {
        $parm = array(BUS_UNIT, $this->yearPick, $this->eventType, $this->poolNumber, $this->personID, $a, $this->boxesSelected[$a-1], date("Y-m-d"));
        $ret = $this->sqlTable->execute($sqlName, $parm);
      }
    }
  }

  private function insertPayments() {
    $qty = count($this->boxesSelected);
    $total = ($qty * $this->cost);
    $sqlName = INSERT . PAYMENTS;
    $parm = array(BUS_UNIT, $this->yearPick, $this->personID, $this->eventType, $this->poolNumber, $qty, $this->cost, $total, 'N');
    $ret = $this->sqlTable->execute($sqlName, $parm);
  }

  private function excludedSquares() {
    $sqlName = LOAD . SQUARES . BY . BOX_NUMBER;
    $parm = array(BUS_UNIT, $this->yearPick, $this->poolNumber, $this->eventType, $this->boxSelected);
    $rs = $this->sqlTable->load($sqlName, $parm);

    foreach ($rs As $r) {
      $sqrNbr = $r['SquareNbr'];
      $excludedFlag = false;
      for ($x = 0; $x < count($this->boxes); $x++) {
        if ($this->boxes[$x] == $sqrNbr) {
          $excludedFlag = true;
          $this->boxes[$x] = 0;
        }
      }
      if ($excludedFlag == true) {
        if ($this->boxExcluded != '') $this->boxExcluded .= ', ';
        $this->boxExcluded .= $sqrNbr;
      }
    }

    $selectBoxes = '';
    for ($y = 0; $y < count($this->boxes); $y++) {
      if ($this->boxes[$y] > 0) {
        if ($selectBoxes != '') $selectBoxes .= ', ';
        $selectBoxes .= $this->boxes[$y];
      }
    }

    $this->boxesSelected = comma_separated_to_array($selectBoxes);
    $this->selectBoxes = $selectBoxes;
  }

  public function addParticipants() {
    $this->excludedSquares();
    if (sizeof($this->boxesSelected) > 0) {
      $this->getUniqueID('PersonID');
      $this->insertParticipant();
      $this->insertPeoplePicks();
      $this->insertPayments();
    }
  }

  public function printConferenceTeams($conference) {
    $rows = $this->sqlTable->load(LOAD . CONFERENCE . TEAMS, array($conference));
    foreach ($rows as $row) echo '<option value="' . $row['Team'] . '">' . $row['TeamName'] . '</option>' . "\n";
  }

  public function loadPopulatePicks() {
    $parm = array($this->yearPick, $this->eventType, $this->poolNumber);
    return $this->sqlTable->load('loadFinalSquares', $parm);
  }

  public function getSquares() {
    $parm = array(BUS_UNIT, $_GET['id'], $_GET['yr'], $_GET['event'], $_GET['pool']);
    $rows = $this->sqlTable->load('getSquares', $parm);
    $this->saved = '';
    foreach ($rows as $row) {
      if ($this->saved != '') $this->saved .= ',';
      $this->saved .= $row['SquareNbr'];
    }
    return $rows;
  }

  public function getNames($person_id) {
    $rows = $this->sqlTable->load('getParticipantName', array(BUS_UNIT, $person_id));
    $full_name = '';
    foreach ($rows as $row) $full_name = $row['FullName'];
    return $full_name;
  }
}
?>
