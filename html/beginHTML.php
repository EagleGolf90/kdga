<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
  <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
  <meta charset="utf-8">
<?php if (PAGE_NAME == 'leaderboard.php' || PAGE_NAME == 'two_day.php') { ?>
  <meta http-equiv="refresh" content="900">
<?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php include('../head_titles.php'); ?></title>
  <?php include('css_finder.php'); ?>
</head>

<?php
switch ($file_name) {
  case 'scores/index.php':
  case 'scores/enterScores_orig.php':
?>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<?php
    break;
  case 'admin/index.php':
?>
<body class="text-center">
<?php
    break;
  case 'scores/test1.php':
?>
<body class="bg-body-tertiary">
<?php
    break;
}
?>
