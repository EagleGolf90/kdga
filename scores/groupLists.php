<?php
include('../preload.php');
include(CLASSES . 'golf_scores.class.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo BUS_UNIT; ?> Group List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="css/kdga-style.css" rel="stylesheet">
</head>
<body>

<form id="regForm" method="post" action="update_scores.php">
  <div class="container">
    <h2 class="header">Enter Scores</h2>
<?php
$s = new GolfScores('Group');
$total = $s->GetTotalCount()-1;

for ($x = 0; $x <= $total; $x++) {
  $names = $s->GetGroupLists($x);
?>
      <div class="row">
        <h4>
        <?php echo 'Group ' . ($x+1) . ': <a href="enter_scores.php?group=' . ($x+1) . '">' . $names . '</a><br/>'; ?>
        </h4>
      </div>
<?php
}
?>
  </div>
</form>

</body>
</html>
