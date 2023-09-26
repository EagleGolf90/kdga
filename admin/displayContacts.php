    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
<?php
$count = 0;
foreach ($contacts_row as $contact) {
  $delete_link = 'delete.php?page=contacts&id=' . $contact['PlayerID'];
?>
        <tr>
          <td><?php echo $contact['LastName'] . ', ' . $contact['FirstName']; ?></td>
          <td><?php echo $contact['Organization']; ?></td>
          <td><a href="<?php echo $delete_link; ?>">Delete</a></td>
        </tr>
<?php
  $count += 1;
}
?>
        <tr><td colspan="2"><b>Total: <?php echo $count; ?></b></td></tr>
        </table>
      </div>
    </div>
