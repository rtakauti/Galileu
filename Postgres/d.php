<?php
echo  realpath( __DIR__.'/conversor/connection/config/config.ini').PHP_EOL;
//var_dump($argv);
/*
if(isset($argv[1])){
	echo "hvhdhhhfvhfh";
}
*/
date_default_timezone_set('America/Sao_Paulo');
mkdir(__DIR__."/teste12".date('d'), 0777);