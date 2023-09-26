<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bus_unit = strtolower($_POST['bu']);
} else {
  if (empty($_GET['bu'])) {
    die('<h2>Must provide correct URL. Please try again.</h2>');
  }
  $bus_unit = strtolower($_GET['bu']);
}

include('bus_unit/load_' . $bus_unit . '.php');
?>
