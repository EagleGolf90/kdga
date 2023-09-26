    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
<?php
$count = 0;
$oldGroupID = '';
foreach ($players_row as $display) {
  if ($oldGroupID != $display['GroupID']) {
    $delete_link = 'delete.php?page=pairings&roundPlayed=' . $roundPlayed . '&group=' . $display['GroupID'];
?>
        <tr class="pairing_header"><td>Group <?php echo $display['GroupID']; ?></td><td style="text-align: right"><a href="<?php echo $delete_link; ?>">Delete</a></td></tr>
<?php
  }
?>
        <tr><td colspan="2"><?php echo $display['LastName'] . ', ' . $display['FirstName']; ?></td></tr>
<?php
  $oldGroupID = $display['GroupID'];
  $count += 1;
}
?>
        <tr><td colspan="2"><b>Total: <?php echo $count; ?></b></td></tr>
        </table>
      </div>
    </div>
