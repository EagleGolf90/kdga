<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$players = $golf->getPlayers($roundPlayed);

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h1><?php echo $courseInfo[0][1]; ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h2><?php echo $date_played; ?></h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h3><?php echo $courseInfo[0][3] . ', ' . $courseInfo[0][4]; ?></h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h4>Course Rating: <?php echo $courseInfo[0][5]; ?></h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h4>Slope Rating: <?php echo $courseInfo[0][6]; ?></h4>
    </div>
  </div>
  <hr/>

<?php
$oldGroupID = '';
$score_flag = false;
for ($x = 0; $x < sizeof($players); $x++) {
  if ($oldGroupID != $players[$x][0]) {
    if ($x > 0) {
      if ($score_flag) {
        $url_link = $groupPlayers;
      } else {
        $url_link = '<a href="enterScores.php?group=' . $oldGroupID . '&round=' . $roundPlayed . '">' . $groupPlayers . '</a>';
      }
      $score_flag = false;
?>
  <div class="row">
    <div class="col-md-2">&nbsp;</div>
    <div class="col-md-2 text-right">Group <?php echo $oldGroupID; ?></div>
    <div class="col-md-6"><?php echo $url_link; ?></div>
    <div class="col-md-2">&nbsp;</div>
  </div>
<?php
      $groupPlayers = '';
    }
  }
  if ($groupPlayers != '') $groupPlayers .= ', ';
  $groupPlayers .= $players[$x][1];
  if (!empty($players[$x][3])) {
    $groupPlayers .= ' (' . $players[$x][3] . ')';
    $score_flag = true;
  }
  $oldGroupID = $players[$x][0];
}
if ($oldGroupID != $players[$x][0]) {
  if ($score_flag) {
    $url_link = $groupPlayers;
  } else {
    $url_link = '<a href="enterScores.php?group=' . $oldGroupID . '&round=' . $roundPlayed . '">' . $groupPlayers . '</a>';
  }
?>
  <div class="row">
    <div class="col-md-2">&nbsp;</div>
    <div class="col-md-2 text-right">Group <?php echo $oldGroupID; ?></div>
    <div class="col-md-6"><?php echo $url_link; ?></div>
    <div class="col-md-2">&nbsp;</div>
  </div>
<?php
}
?>
</div>

<?php include(HTML . 'endHTML.php'); ?>
