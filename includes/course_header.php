<?php
$course_name_flag = false;
$date_played_flag = true;
$enter_score_flag = false;
$location_flag = false;
$rating_flag = false;

if (PAGE_NAME == 'enter_scores.php' || PAGE_NAME == 'groups.php') {
  $course_name_flag = true;
  $location_flag = true;
  $enter_score_flag = true;
  $rating_flag = true;
}

if (PAGE_NAME == 'leaderboard.php' || PAGE_NAME == 'net_scores.php') {
  $course_name_flag = true;
  $location_flag = true;
  if (PAGE_NAME == 'net_scores.php') $date_played_flag = false;
}

if ($course_name_flag == true || $enter_score_flag == true) {
  $display_message = '<h1>' . $courseInfo[0][1] . '</h1>';
  include(INCLUDES . 'display_message.php');
}

if ($date_played_flag == true || $enter_score_flag == true) {
  $display_message = '<h2>' . $date_played . '</h2>';
  include(INCLUDES . 'display_message.php');
}

if ($location_flag == true) {
  $display_message = '<h3>' . $courseInfo[0][3] . ', ' . $courseInfo[0][4] . '</h3>';
  include(INCLUDES . 'display_message.php');
}

if ($rating_flag == true) {
  $display_message = '<h4>Course Rating: ' . $courseInfo[0][5] . '</h4>';
  include(INCLUDES . 'display_message.php');

  $display_message = '<h4>Slope Rating: ' . $courseInfo[0][6] . '</h4>';
  include(INCLUDES . 'display_message.php');
}
?>
