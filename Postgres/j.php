<?php
$a = array('Dog'=>'Fido','Cat'=>'Fify');
$b = array('Cat'=>'Fify', 'Dog'=>'Fido');
$c[]='dog';
$c[]='cat';
$d[]='dog';
$d[]='cat';

if($a == $b) echo 'igual<br/>';
if($c == $d) echo 'igual';