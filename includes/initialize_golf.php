<?php
include(CLASSES . 'golf_scores.class.php');
$golf = new GolfScores();
$rounds = $golf->getRounds();
?>
