<?php
if (PAGE_NAME != 'which_page.php') {
  $roundPlayed = 0;
  if (PAGE_NAME == 'enterScores.php') {
    $roundPlayed = $_GET['round'];
  } else {
    if (PAGE_NAME != 'two_day.php' && PAGE_NAME != 'leaderboard.php' && PAGE_NAME != 'net_scores.php') {
      $roundPlayed = $_GET['roundPlayed'];
    }
  }
  $roundPlayed = $golf->getRoundPlayed($roundPlayed);
  $roundID = $golf->getRoundID();

  $courseInfo = $golf->getCourseInfo($roundPlayed);
  $holes = $golf->getCourseDetails();

  $allpars = '';
  for ($idx = 0; $idx < sizeof($holes); $idx++) {
    if ($allpars != '') $allpars .= ',';
    $allpars .= $holes[$idx][0];
  }

  $course_name = $courseInfo[0][1];
  $temp_date_played = date_create($courseInfo[0][2]);
  $date_played = date_format($temp_date_played, "l, F d, Y");
  $location = $courseInfo[0][3] . ', ' . $courseInfo[0][4];
}
?>
