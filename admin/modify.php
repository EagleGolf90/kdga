<?php
if (!isset($_GET['page'])) die('Must have page parameter. Please try again.');

include('../preload.php');
include(INCLUDES . 'initialize_golf.php');

$location = ADMIN_URL;
switch (strtolower($_GET['page'])) {
  case 'modifysetup':
    $golf->modifySetup();
    $location .= 'manageSetup.php';
    break;
  case 'modifyscores':
    $golf->updateScores($_GET['id'], $_GET['roundPlayed'], $_GET['hole'], $_GET['score']);
    $location .= 'editScores.php?roundPlayed=' . $_GET['roundPlayed'];
    break;
}
$golf = null;

header("Location: " . $location);
exit;
?>
