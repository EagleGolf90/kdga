    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover table-bordered">
<?php
$count = 0;
$tristate = 0;
$two_day = 0;
foreach ($players_row as $display) {
  $name_value = $display['LastName'] . ', ' . $display['FirstName'];
  $delete_link = 'delete.php?page=participants&id=' . $display['PlayerID'];
?>
        <tr>
          <td><?php echo $name_value; ?></td>
          <td><?php echo $display['Organization']; ?></td>
          <td><?php echo $display['PlayerChoice']; ?></td>
          <td><a href="<?php echo $delete_link; ?>">Delete</d></td>
        </tr>
<?php
  if ($display['Event'] == 1) $tristate += 1;
  if ($display['Event'] == 2) $two_day += 1;
  $count += 1;
}
?>
        <tr><td colspan="3"><b>Tri-State Total: <?php echo $tristate; ?></b></td></tr>
        <tr><td colspan="3"><b>Two-Day Total: <?php echo $two_day; ?></b></td></tr>
        <tr><td colspan="3"><b>Total: <?php echo $count; ?></b></td></tr>
        </table>
      </div>
    </div>
