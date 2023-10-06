<?php
if (!isset($_GET['role'])) die('Must have role parameter. Please try again.');
$role = strtolower($_GET['role']);

include('../preload.php');
include(HTML . 'beginHTML.php');
?>

<div class="container-fluid">
  <?php include('menu_nav.php'); ?>
</div>

<?php include(HTML . 'endHTML.php'); ?>
