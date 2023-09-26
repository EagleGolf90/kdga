    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover table-bordered">
<?php
$count = 0;
foreach ($players_row as $display) {
  $name_value = $display['LastName'] . ', ' . $display['FirstName'];
  $delete_link = 'delete.php?page=participants&id=' . $display['PlayerID'] . '&roundPlayed=' . $_GET['roundPlayed'];
?>
        <tr>
          <td colspan="3"><?php echo $name_value; ?></td>
          <td><a href="<?php echo $delete_link; ?>">Delete</d></td>
        </tr>
<?php
  $count += 1;
}
?>
        <tr><td colspan="4"><b>Total: <?php echo $count; ?></b></td></tr>
        </table>
      </div>
    </div>
