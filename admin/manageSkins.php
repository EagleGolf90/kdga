<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
$rows = $golf->loadRoundPlayed();
$participants = $golf->getSkinsParticipants();
$players_row = $golf->displaySkinsParticipants();

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form class="regForm" action="add.php" method="post">
  <input type="text" name="page" value="skins" hidden>
  <div class="container-list">
    <?php
    $display_message = '<h3>Manage Skins</h3>';
    include(INCLUDES . 'display_message.php');
    ?>

    <div row="row">
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <select name="roundPlayed" class="form-control">
            <option value="" selected>Select one</option>
            <?php foreach ($rows as $row) { ?>
            <option value="<?php echo $row['RoundPlayed']; ?>"><?php echo $row['DatePlayed']; ?></option>
            <?php } ?>
          </select>
          <label for="roundPlayed">Date Played</label>
        </div>
      </div>
    </div>

    <div row="row">
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <select name="playerID" class="form-control">
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
    <div class="row">
      <div class="col-md-12">
        <div class="form-check">
          <input class="form-check-input" name="paid" type="checkbox" value="1" id="flexCheckDefault">
          <label class="form-check-label" for="paid"> Paid?</label>
        </div>
      </div>
    </div>

    <?php include(INCLUDES . 'submit_button.php'); ?>

    <hr/>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover table-bordered">
<?php
$count = 0;
$total_paid = 0;
$total_unpaid = 0;
foreach ($players_row as $display) {
  $name_value = $display['LastName'] . ', ' . $display['FirstName'];
  $delete_link = 'delete.php?page=skins&round=' . $display['RoundPlayed'] . '&id=' . $display['PlayerID'];
?>
        <tr>
          <td><?php echo $name_value; ?></td>
          <td class="text-center"><?php echo $display['Paid']; ?></td>
          <td><a href="<?php echo $delete_link; ?>">Delete</d></td>
        </tr>
<?php
  if ($display['Paid'] == 'Y') $total_paid += 1;
  if ($display['Paid'] == 'N') $total_unpaid += 1;
  $count += 1;
}
?>
        <tr><td colspan="3"><b>Total Paid: <?php echo $total_paid; ?></b></td></tr>
        <tr><td colspan="3"><b>Total Unpaid: <?php echo $total_unpaid; ?></b></td></tr>
        <tr><td colspan="3"><b>Totals: <?php echo $count; ?></b></td></tr>
        </table>
      </div>
    </div>
  </div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
