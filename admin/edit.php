<?php
include('../preload.php');
include(CLASSES . 'edit_scores.class.php');
$golf = new EditScores();

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form action="update_scores.php" method="post" name="editForm">
  <input type="text" name="roundPlayed" value="<?php echo $_GET['roundPlayed']; ?>" hidden>
  <input type="text" name="playerID" value="<?php echo $_GET['id']; ?>" hidden>
  <input type="text" name="holeNumber" value="<?php echo $_GET['hole']; ?>" hidden>
  <input type="text" name="page" value="editscores" hidden>

  <div class="container">
    <div class="row">
      <div class="col-md-4">&nbsp;</div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover table-striped">
        <tr><td class="scores">Hole #</td><td class="scores">Score</td></tr>
        <tr>
          <td class="scores"><?php echo $_GET['hole']; ?></td>
          <td class="scores"><input type="number" name="scores" class="form-control" value="<?php echo $_GET['score']; ?>"></td>
        </tr>
      </div>
      <div class="col-md-4">&nbsp;</div>
    </div>

    <?php include(INCLUDES . 'submit_button.php'); ?>
  </div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
