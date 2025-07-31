  <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Indiana</a></li>
      <li><a href="#tabs-2">Kentucky</a></li>
      <li><a href="#tabs-3">Ohio</a></li>
    </ul>

    <div class="row">
      <div class="col-md-12">
<?php
$count = 0;
for ($i = 0; $i < 3; $i++) {
?>
      <div id="tabs-<?php echo ($i + 1); ?>">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Organization</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
<?php
  $contacts_row = $golf->displayContacts($i+1);
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
<?php
  $count = 0;
}
?>
      </div>
    </div>
  </div>
