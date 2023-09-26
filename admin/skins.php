<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$skins = $golf->checkSkins($roundPlayed);

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<div class="container">
  <?php
  $display_message = '<h1>' . $courseInfo[0][1] . '</h1>';
  include(INCLUDES . 'display_message.php');

  $display_message = '<h2>' . $date_played . '</h2>';
  include(INCLUDES . 'display_message.php');

  $display_message = '<h3>' . $courseInfo[0][3] . ', ' . $courseInfo[0][4] . '</h3>';
  include(INCLUDES . 'display_message.php');
  ?>
  <hr/>

<?php
$oldHoleNumber = 0;
foreach ($skins as $skin) {
  $fullName = $skin['LastName'] . ', ' . $skin['FirstName'];
  if ($oldHoleNumber != $skin['HoleNumber']) {
?>
   <div class="row">
     <div class="col-md-2">&nbsp;</div>
     <div class="col-md-6 text-center"><h2>Hole <?php echo ($oldHoleNumber+1); ?></h2></div>
     <div class="col-md-4">&nbsp;</div>
   </div>
<?php
  }
?>
  <div class="row">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-3"><?php echo $fullName; ?></div>
    <div class="col-md-3">
      <?php echo '<span class="' . $skin['tag_name'] . '">' . $skin['Stroke'] . '</span>'; ?>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>
<?php
  $oldHoleNumber = $skin['HoleNumber'];
}
?>
</div>

<?php include(HTML . 'endHTML.php'); ?>
