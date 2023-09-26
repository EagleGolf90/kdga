<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
include(HTML . 'beginHTML.php');
?>

<form id="regForm" action="update_scores.php" method="post">
  <input type="text" name="NumberOfPlayers" value="<?php echo sizeof($players); ?>" hidden>
<?php for ($y = 0; $y < sizeof($players); $y++) { ?>
  <input type="text" name="player[]" value="<?php echo $players[$y][2]; ?>" hidden>
<?php } ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 text-center">
      <h1><?php echo $courseInfo[0][1]; ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 text-center">
      <h2><?php echo $date_played; ?></h2>
    </div>
  </div>

<?php
for ($y = 0; $y < 18; $y++) {
  $holeNumber = ((($y + 1) < 10) ? '0' : '') . ($y+1);
  $maxPar = $holes[$y][0] + 4;
?>
  <div class="tab">
    <h1><?php echo 'Hole ' . ($y+1) . ' - Par ' . $holes[$y][0] . ', Yards ' . $holes[$y][1]; ?></h1>
<?php for ($z = 0; $z < sizeof($players); $z++) {
        $player_id = '';
        if ($players[$z][2] < 100) $player_id = '0' . $players[$z][2];
        if ($players[$z][2] < 10) $player_id = '00' . $players[$z][2];
        $name_id = 'p_' . $player_id . '_' . $holeNumber;
        $score_id = 'scores' . $player_id;
?>
    <div class="row">
      <div>&nbsp;</div>
      <div class="col-sm-6">
        <label class="name_label text-right"><?php echo $players[$z][1]; ?></label>
      </div>
    </div>
    <div class="row">
      <div>&nbsp;</div>
      <div class="col-sm-3">
        <input type="number" pattern="[0-9]*" name="<?php echo $score_id; ?>[]" id="<?php echo $name_id; ?>" class="form-control holes" value="" onkeyup="display('<?php echo $name_id; ?>')" min="1" max="<?php echo $maxPar; ?>">
      </div>
      <div class="col-sm-4"><label class="text-center" id="par_label_<?php echo $name_id; ?>">&nbsp;</label></div>
    </div>
<?php } ?>
  </div>
<?php
}
?>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>

  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;" hidden>
<?php for ($x = 1; $x <= 18; $x++) { ?>
    <span class="step"></span>
<?php } ?>
  </div>
</div>
</form>

<?php
include(HTML . 'scripts.php');
include(HTML . 'endHTML.php');
?>
