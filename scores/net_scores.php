<?php
if (!isset($_GET['role'])) die('Must have role parameter. Please try again.');
$role = strtolower($_GET['role']);

include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$rows = $golf->loadNetScoreLeaderboard();

include(HTML . 'beginHTML.php');
if ($role == 'admin') include(MENUS . 'navbar.php');
if ($role == 'user') {
  $url_link = MENUS_URL . '?role=' . $role;
  include(MENUS . 'return_menu.php');
}
?>

<div class="container">
  <?php include(INCLUDES . 'course_header.php'); ?>
  <hr/>

  <?php
  $display_message = '<h2>IDGA Two-Day Leaderboard - Net Score<h2>';
  include(INCLUDES . 'display_message.php');
  ?>

  <div class="row">
    <table class="table table-bordered table-hover table-striped">
    <tr>
      <td class="col text-center header">Place</td>
      <td class="col-md-2 text-center header">Name</td>
      <td class="col text-center header">Rnd 1</td>
      <td class="col text-center header">Rnd 2</td>
      <td class="col text-center header">Total</td>
      <td class="col text-center header">HCP</td>
      <td class="col text-center header">Net</td>
    </tr>

<?php
$place = 0;
$oldScore = 0;
$tied = 0;
foreach ($rows as $row) {
  if ($oldScore != $row['TotalScore']) {
    $place += ($tied + 1);
    $tied = 0;
  } else {
    $tied += 1;
  }
?>
    <tr>
      <td class="col text-center"><?php echo $place; ?></td>
      <td class="col-md-2"><?php echo $row['LastName'] . ', ' . $row['FirstName']; ?></td>
      <td class="col text-center"><?php echo $row['R1']; ?></td>
      <td class="col text-center"><?php echo $row['R2']; ?></td>
      <td class="col text-center"><?php echo $row['TotalScore']; ?></td>
      <td class="col text-center"><?php echo $row['handicap']; ?></td>
      <td class="col text-center"><?php echo $row['NetScore']; ?></td>
    </tr>
<?php
    $oldScore = $row['TotalScore'];
}
?>
    </table>
  </div>
</div>

<?php include(HTML . 'endHTML.php'); ?>
