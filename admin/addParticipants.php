<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
$participants = $golf->getParticipants();
$players_row = $golf->displayParticipants();

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form class="regForm" action="add.php" method="post">
  <input type="text" name="page" value="participants" hidden>
  <div class="container-list">
    <?php
    $display_message = '<h3>Add Participant</h3>';
    include(INCLUDES . 'display_message.php');
    ?>

    <div row="row">
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <select name="playerID" class="form-control" required>
            <option value="" selected>Select one</option>
<?php
foreach ($participants as $participant) {
  $name_value = $participant['LastName'] . ', ' . $participant['FirstName'] . ' (' . $participant['Organization'] . ')';
?>
            <option value="<?php echo $participant['PlayerID']; ?>"><?php echo $name_value; ?></option>
<?php
}
?>
          </select>
          <label for="playerID">Name</label>
        </div>
      </div>
    </div>

    <?php
    //include(INCLUDES . 'select_events.php');
    include(INCLUDES . 'submit_button.php');
    ?>

    <hr/>

    <?php include('displayParticipants.php'); ?>
  </div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
