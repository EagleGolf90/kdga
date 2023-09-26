<?php
if (!isset($_GET['role'])) die('Must have role parameter. Please try again.');
$role = strtolower($_GET['role']);

include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$rows = $golf->getLeaderboard();
$teams = $golf->getTeamScores();

include(HTML . 'beginHTML.php');
if ($role == 'admin') include(MENUS . 'navbar.php');
if ($role == 'user') {
  $url_link = MENUS_URL . '?role=' . $role;
  include(MENUS . 'return_menu.php');
}
?>

<div class="container">
  <?php include(INCLUDES . 'course_header.php'); ?>

  <div class="row">
<?php
$oldOrganization = '';
$x = 0;
$team_cut = 0;
foreach ($rows as $row) {
  if ($golf->isTeamFinalCut($team_cut) && $scores_flag == true) echo $golf->separator();

  if ($oldOrganization != $row['Organization']) {
    $team_cut = 0;
    if ($golf->isSecondRowOrMore($x)) {
?>
      </table>
    </div>
<?php
    }
    $team_score = $teams[$x][2];
?>
    <div class="col-md-4 text-center">
      <table class="table table-bordered table-hover table-striped">
      <tr><td colspan="2"><h2><?php echo $row['Organization'] . (empty($team_score) ? '' : ' (' . $team_score . ')'); ?></h2></td></tr>
<?php
    $x++;
  }
  echo $golf->printGolferName($row);
  $oldOrganization = $row['Organization'];
  $team_cut++;
}
?>
  </div>

</div>

<?php include(HTML . 'endHTML.php'); ?>
