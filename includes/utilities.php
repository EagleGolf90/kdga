<?php
/**
 * @param $string - Input string to convert to array
 * @param string $separator - Separator to separate by (default: ,)
 *
 * @return array
 */
function comma_separated_to_array($string, $separator = ',') {
  //Explode on comma
  $vals = explode($separator, $string);

  //Trim whitespace
  foreach ($vals as $key => $val) {
    $boxes[$key] = trim($val);
  }
  //Return empty array if no items found
  //http://php.net/manual/en/function.explode.php#114273

  return array_diff($boxes, array(""));
}
?>
