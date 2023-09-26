<?php
include('../preload.php');

include(CLASSES . 'edit_scores.class.php');
$golf = new EditScores();
$golf->updateScores();
$golf = null;

$location = ADMIN_URL . 'editScores.php?roundPlayed=' . $_POST['roundPlayed'];
header("Location: " . $location);
exit;
?>
