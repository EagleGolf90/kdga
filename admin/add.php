<?php
if (!isset($_POST['page'])) die('Must have page parameter. Please try again.');

include('../preload.php');

include(CLASSES . 'golf_scores.class.php');
$object = new GolfScores();
$methodName = 'add' . ucwords($_POST['page']);
$location = ADMIN_URL . $object->getRedirectLink(strtolower($_POST['page']), $_POST['roundPlayed']);

if (!method_exists($object, $methodName)) die('Something isn\'t working. Please check with Administrator.');

$object->$methodName();

if (strtolower($_POST['page']) == 'scores') echo '<h2><a href="' . $location . '">Return to Scores</a></h2>' . "\n";
header("Location: " . $location);
exit;

$object = null;
?>
