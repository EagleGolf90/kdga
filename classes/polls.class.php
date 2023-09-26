<?php
class Polls {
    private $sqlTable;
    private $who_propose;
    private $proposal;
    private $seconded;
    private $amended = '';
    private $date_vote;

    public function __construct() {
      $this->sqlTable = new SQLTable();
      $this->load();
    }

    public function getProposeStatement() { return $this->proposal; }
    public function getWhoPropose() { return $this->who_propose; }
    public function getSeconded() { return $this->seconded; }

    private function load() { $this->loadProposals(); }

    private function loadProposals() {
      $rows = $this->sqlTable->load('loadLastProposals', array());
      foreach ($rows as $row) {
        $this->proposal = $row['proposal_question'];
        $this->who_propose = $row['proposed'];
        $this->seconded = $row['seconded'];
      }
    }

    private function loadAmends() {
      $rows = $this->sqlTable->load('loadLastAmends', array());
      foreach ($rows as $row) $this->amended = $row['amend_line'];
    }

    public function printSelectOptions() {
      $rows = $this->sqlTable->load('', array());
      foreach ($rows as $row) echo '<option value="' . $row['secure_id'] . '">' . $row['FullName'] . '</option>' . "\n";
    }
}
?>
