<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');
include(INCLUDES . 'course_init.php');
$rows = $golf->getAllScores($roundPlayed);

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<div class="container-fluid">
  <?php
  $display_message = '<h2>IDGA All Scores<h2>';
  include(INCLUDES . 'display_message.php');
  ?>

  <div class="row">
    <table class="table table-dark table-striped table-hover">
    <tr class="table-primary">
      <td class="text-center">Hole</td>
<?php for ($x = 1; $x <= 18; $x++) {
        if ($x == 10) echo '<td class="text-center">OUT</td>' . "\n";
?>
      <td class="text-center"><?php echo $x; ?></td>
<?php } ?>
      <td class="text-center">IN</td>
      <td class="text-center">TOT</td>
    </tr>

    <tr class="table-success">
      <td class="text-center">Par</td>
<?php $front9 = 0;
      $back9 = 0;
      for ($x = 0; $x < 18; $x++) {
        $par = $holes[$x][0];
        if ($x < 9) $front9 += $par;
        if ($x >= 9) $back9 += $par;
        if ($x == 9) echo '<td class="text-center">' . $front9 . '</td>' . "\n";
?>
      <td class="scores"><?php echo $par; ?></td>
<?php } ?>
      <td class="text-center"><?php echo $back9; ?></td>
      <td class="text-center"><?php echo ($front9 + $back9); ?></td>
    </tr>

    <tr class="table-secondary">
      <td class="text-center">HCP</td>
<?php for ($x = 0; $x < 18; $x++) {
        if ($x == 9) echo '<td class="text-center">&nbsp;</td>' . "\n";
?>
      <td class="scores"><?php echo $holes[$x][2]; ?></td>
<?php } ?>
      <td class="text-center">&nbsp</td>
      <td class="text-center">&nbsp</td>
    </tr>

<?php
foreach ($rows as $row) {
?>
    <tr>
      <td class="scores"><?php echo $row['LastName'] . ', ' . $row['FirstName']; ?></td>
<?php
  $front9 = $row['Front9'];
  $back9 = $row['Back9'];
  for ($x = 1; $x <= 18; $x++) {
    $fieldName = 'Score' . strval($x);
    if ($x == 10) echo '<td class="scores">' . $front9 . '</td>' . "\n";
?>
      <td class="scores"><?php echo $row[$fieldName]; ?></td>
<?php
  }
?>
      <td class="scores"><?php echo $back9; ?></td>
      <td class="scores"><?php echo ($front9 + $back9); ?></td>
    </tr>
<?php
}
?>
    </table>
  </div>
</div>

<?php include(HTML . 'endHTML.php'); ?>
