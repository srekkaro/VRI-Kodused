<?php

$string="See On String, mille keerame tagurpidi!";

for ($i = strlen($string)-1; $i>=0; $i--) {
       $string .= $string[$i];
       $string[$i] = NULL;
 }
echo $string;

?>
