<?php
include('../preload.php');
include(CLASSES . 'edit_scores.class.php');
$golf = new EditScores();
$scores = $golf->getPlayersScores($_GET['id'], $_GET['roundPlayed']);
$link = 'edit.php?id=' . $_GET['id'] . '&roundPlayed=' . $_GET['roundPlayed'];

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form action="#" method="post" name="editForm">
  <input type="text" name="roundPlayed" value="<?php echo $_GET['roundPlayed']; ?>" hidden>
  <input type="text" name="playerID" value="<?php echo $_GET['id']; ?>" hidden>
  <div class="container">
    <?php
    $display_message = '<h1>Edit Scores - ' . $golf->getFullName() . ' (' . $golf->getOrganization() . ')</h1>';
    include(INCLUDES . 'display_message.php');
    ?>

    <div class="row">
      <div class="col-md-4">&nbsp;</div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover table-striped">
        <tr><td class="scores">Hole #</td><td class="scores">Score</td><td>&nbsp;</td></tr>
        <?php foreach ($scores as $score) {
                $edit_link = $link . '&hole=' . $score['HoleNumber'] . '&score=' . $score['HoleScore'];
        ?>
        <tr>
          <td class="scores"><?php echo $score['HoleNumber']; ?></td>
          <td class="scores"><?php echo $score['HoleScore']; ?></td>
          <td class="scores"><a href="<?php echo $edit_link; ?>">Edit</a></td>
        </tr>
        <?php } ?>
      </div>
      <div class="col-md-4">&nbsp;</div>
    </div>
  </div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
