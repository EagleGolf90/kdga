<?php
$name_url = $_SERVER['PHP_SELF'];
$file_name = str_replace(DS . 'tristate' . DS, "", $name_url);

switch ($file_name) {
  default:
    include(HTML . 'head_scores.php');
    break;
}
?>
