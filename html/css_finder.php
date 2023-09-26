<?php
$name_url = $_SERVER['PHP_SELF'];
$file_name = str_replace(DS . 'tristate' . DS, "", $name_url);

switch ($file_name) {
  case 'menus/index.php':
  // case 'admin/index.php':
    include(HTML . 'head_menus.php');
    break;
  //   include(HTML . 'head_admin.php');
  //   break;
  // case 'scores/index.php':
  // case 'scores/skins.php':
  // case 'scores/enterScores.php':
  // case 'scores/enterScores_mobile.php':
  // case 'scores/leaderboard.php':
  // case 'scores/two_day.php':
  // case 'scores/addContacts.php':
  // case 'scores/addParticipant.php':
  // case 'scores/which_round.php':
  // case 'scores/addPairing.php':
  default:
    include(HTML . 'head_scores.php');
    break;
}
?>
