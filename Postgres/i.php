<?php

$string = "_teste";
if($string[0] == "_") $string[0] = "";
$len = strlen($string);
echo "teste.$string <br/>";
$string[0] = $string[strlen($string)] = "0";
echo $string;