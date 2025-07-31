<?php
include('../preload.php');
include(CLASSES . 'edit_scores.class.php');
$golf = new EditScores();
$players = $golf->getPlayers($_GET['roundPlayed']);

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form class="regForm" action="add.php" method="post">
<div class="container">
  <input type="text" name="page" value="edit_scores" hidden>
  <input type="text" name="roundPlayed" value="<?php echo $roundPlayed; ?>" hidden>
  <input type="text" name="roundID" value="<?php echo $roundID; ?>" hidden>

  <?php
  $display_message = '<h2>Edit Scores</h2>';
  include(INCLUDES . 'display_message.php');
  ?>

  <div class="row">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-6">
      <table class="table table-bordered table-hover table-striped">
      <tr><th>Name</th><th class="scores">Score</th><th>&nbsp;</th></tr>
<?php
foreach ($players as $player) {
  $edit_link = 'Edit Score';
  if (!empty($player['TotalScore'])) {
    $edit_link = '<a href="modifyScores.php?page=scores&roundPlayed=' . $_GET['roundPlayed'] . '&id=' . $player['PlayerID'] . '">Edit Score</a>';
  }
?>
      <tr>
        <td class="score_name"><?php echo $player['LastName'] . ', ' . $player['FirstName']; ?></td>
        <td class="scores"><?php echo $player['TotalScore']; ?>
        <td><?php echo $edit_link; ?></td>
      </tr>
<?php } ?>
      </table>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>

  <?php include(INCLUDES . 'submit_button.php'); ?>
</div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
