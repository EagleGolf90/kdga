<?php
if (!isset($_GET['page'])) die('Must have page parameter. Please try again.');

include('../preload.php');

include(CLASSES . 'golf_scores.class.php');
$golf = new GolfScores();

$location = ADMIN_URL;

switch (strtolower($_GET['page'])) {
  case 'contacts':
    $golf->deleteContacts($_GET['id']);
    $location .= 'addContacts.php';
    break;
  case 'participants':
    $golf->deleteParticipants($_GET['id']);
    $location .= 'addParticipants.php';
    break;
  case 'pairings':
    $golf->deletePairings($_GET['round'], $_GET['group']);
    $location .= 'addPairings.php?roundPlayed=' . $_GET['round'];
    break;
  case 'skins':
    $golf->deleteSkins($_GET['round'], $_GET['id']);
    $location .= 'manageSkins.php';
    break;
}
$golf = null;

header("Location: " . $location);
exit;
?>
