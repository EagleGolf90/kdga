<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$players = $golf->getGroups($roundPlayed, $_GET['group']);

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form class="regForm" action="add.php" method="post">
<div class="container-fluid">
  <input type="text" name="page" value="scores" hidden>
  <input type="text" name="NumberOfPlayers" value="<?php echo sizeof($players); ?>" hidden>
  <input type="text" name="roundPlayed" value="<?php echo $roundPlayed; ?>" hidden>
  <input type="text" name="roundID" value="<?php echo $roundID; ?>" hidden>
<?php for ($y = 0; $y < sizeof($players); $y++) { ?>
  <input type="text" name="player[]" value="<?php echo $players[$y][2]; ?>" hidden>
<?php } ?>

  <div class="row">
    <div class="col-sm-12 text-center">
      <h3><?php echo $courseInfo[0][1]; ?></h3>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 text-center">
      <h4><?php echo $date_played; ?></h4>
    </div>
  </div>

<?php for ($z = 0; $z < sizeof($players); $z++) {
        $player_id = '';
        if ($players[$z][2] < 100) $player_id = '0' . $players[$z][2];
        if ($players[$z][2] < 10) $player_id = '00' . $players[$z][2];
?>
    <div class="form-label-group">
      <h3><?php echo $players[$z][1]; ?></h3>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Hole</th>
<?php for ($x = 1; $x <= 18; $x++) { ?>
          <th class="scores"><?php echo $x; ?></th>
<?php } ?>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <th>Par</th>
<?php for ($x = 0; $x < 18; $x++) { ?>
          <th class="scores"><?php echo $holes[$x][0]; ?></th>
<?php } ?>
          <th>TOT</th>
        </tr>
        <tr>
          <th>&nbsp;</th>
<?php for ($x = 0; $x < 18; $x++) {
        $holeNumber = ((($x + 1) < 10) ? '0' : '') . ($x+1);
        $maxPar = $holes[$x][0] + 4;
        $name_id = 'p_' . $player_id . '_' . $holeNumber;
        $score_id = 'scores' . $player_id;
?>
          <td class="scores">
            <input type="number" pattern="[0-9]*" onchange="display('<?php echo $holeNumber; ?>', '<?php echo $player_id; ?>')"  name="<?php echo $score_id; ?>[]" id="<?php echo $name_id; ?>" class="form-control holes" value="" min="1" max="<?php echo $maxPar; ?>">
          </td>
<?php } ?>
          <td class="text-center">
            <label id="total_<?php echo $player_id; ?>">0</label>
          </td>
        </tr>
      </table>
    </div>
<?php } ?>

  <?php include(INCLUDES . 'submit_button.php'); ?>
</div>
</form>

<?php
include(HTML . 'scripts.php');
include(HTML . 'endHTML.php');
?>
