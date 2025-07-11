<?php
include('../preload.php');

//include(INCLUDES . 'golf_scores.php');

$course_name = 'Willows';
$date_played = 'Saturday, July 22, 2023';
$players = array("001" => "Brian Timberlake", "027" => "Jeff Cecil", "018" => "Mark Flaherty");
$holes = array(4, 3, 4, 4, 3, 5, 4, 4, 5, 4, 3, 5, 4, 4, 4, 4, 3, 5);

foreach($age as $x => $val) {
  echo "$x = $val<br>";
}

include('beginHTML.php');
?>

<div class="container">
  <form class="form-signin">
    <div class="text-center mb-4">
      <h1 class="ctr"><?php echo $course_name; ?></h1>
      <h5 class="ctr"><?php echo $date_played; ?></h5>
    </div>

<?php foreach ($players as $key => $name) { ?>
    <div class="form-label-group">
      <h3><?php echo $name; ?></h3>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Hole</th>
<?php for ($x = 1; $x <= 18; $x++) { ?>
          <th><?php echo $x; ?></th>
<?php } ?>
        </tr>
        <tr>
          <th>Par</th>
<?php for ($x = 0; $x < 18; $x++) { ?>
          <th><?php echo $holes[$x]; ?></th>
<?php } ?>
        </tr>
        <tr>
          <th>&nbsp;</th>
<?php for ($x = 1; $x <= 18; $x++) {
        $tag_id = 'p_' . ($x < 10 ? '0' : '') . $x . '_' . $key;
?>
          <td><input type="text" id="<?php echo $tag_id; ?>" class="form-control holes" required autofocus></td>
<?php } ?>
        </tr>
      </table>
    </div>
<?php } ?>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
  </form>

</div>

<?php include('endHTML.php'); ?>
