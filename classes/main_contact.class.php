<?php
/*
 * Program Name..: main_contact.class.php
 * Author........: Brian Timberlake
 * Date Created..: September 9, 2019
 */
class MainContact {
  private $sqlTable;
  private $yearPick;
  private $poolNbr;
  private $eventType;
  private $contactName = '';
  private $contactAddress = '';
  private $contactCity = '';
  private $contactState = '';
  private $contactZipCode = '';
  private $contactPhone = '';
  private $phoneTypeDesc = '';
  private $cashApp = '';
  private $mainContactFirstName = '';
  private $mainContactLastName = '';
  private $mainEmailAddress = '';
  private $mainCashApp = '';
  private $emailContent = '';
  private $sql;
  private $address_flag;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->sql = new SQL();
    $this->setup();
  }

  public function setYearPick($yr) { $this->yearPick = $yr; }
  public function setPoolNumber($nbr) { $this->poolNbr = $nbr; }
  public function setEventType($type) { $this->eventType = $type; }

  public function getContactName() { return $this->contactName; }
  public function getContactAddress() { return $this->contactAddress; }
  public function getContactCity() { return $this->contactCity; }
  public function getContactState() { return $this->contactState; }
  public function getContactZipCode() { return $this->contactZipCode; }
  public function getContactPhone() { return $this->contactPhone; }
  public function getContactPhoneType() { return $this->phoneTypeDesc; }
  public function getContactCashApp() { return $this->cashApp; }
  public function getMainContactInfo() { return $this->mainContactFirstName . ' (' . $this->mainEmailAddress . ')'; }
  public function getMainCashApp() { return $this->mainCashApp; }
  public function getMainContactEmail() { return $this->mainEmailAddress; }
  public function getEmailContent() { return $this->emailContent; }

  private function setup() {
    $parm = array(BUS_UNIT);
    $rows = $this->sqlTable->load(LOAD . SETUP, $parm);
    $this->mainContactFirstName = '';
    foreach ($rows as $row) {
      $this->mainContactFirstName = $row['MainFirstName'];
      $this->mainEmailAddress = $row['MainEmailAddress'];
      $this->mainCashApp = $row['MainCashApp'];
    }
  }

  public function printContactInfo($printCashApp) {
    if ($this->address_flag == 'Y') {
      $line = 'Check <strong>or</strong> money order payable to ' . BUS_UNIT . ' and send to <br/>';
      $line .= $this->contactName . ', ' . $this->contactAddress . ', ' . $this->contactCity . ', ';
      $line .= $this->contactState . ', ' . $this->contactZipCode;
    } else {
      $line = 'Contact this text number ' . $this->contactPhone . ' if you have any questions.';
    }
    if ($printCashApp == true) $line .= '<br/>Pay through "CashApp" at ' . $this->cashApp;
    return $line;
  }

  private function replaceContents($content) {
    $parm = array($_POST['BoxNumber'], $this->printContactInfo(false), $this->mainCashApp, $this->mainContactFirstName);
    $this->emailContent = $this->sql->replaceParameters($content, $parm);
  }

  public function getMainContact() {
    $parm = array($this->yearPick, $this->eventType, $this->poolNbr);
    $rs = $this->sqlTable->load(GET . MAIN . CONTACTS, $parm);

    foreach ($rs as $r) {
      $this->contactName = $r['FirstName'] . ' ' . $r['LastName'];
      $this->contactAddress = $r['Address'];
      $this->contactCity = $r['City'];
      $this->contactState = $r['State'];
      $this->contactZipCode = $r['ZipCode'];
      $this->address_flag = $r['ShowAddress'];
      $this->contactPhone = $r['Phone'];
      $this->phoneTypeDesc = $r['PhoneDesc'];
      $this->cashApp = $r['CashApp'];
      $this->replaceContents($r['EmailContent']);
    }
  }
}
?>
