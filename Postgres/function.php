<?php



// Conexao
$dbnameDev = "rubens_teste";
$dbnameHomolog = "rubens_test";
$host = "gdev.galileulog.com.br";
$dbuser = "postgres";
$dbpass = "g@l1l3u2012";

$file = $dbnameHomolog . "_script.sql";

try {

	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbDev->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
	$dbHomolog->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}



function dbToArrayDev($query){
	$find = $dbDev->prepare ( $query );
	$find->execute ();
	$resultado = $find->fetchAll ( PDO::FETCH_NUM );
	$resultadoArray = array ();
	foreach ( $resultado as $values ) {
		foreach ( $values as $value ) {
			$resultadoArray [] = $value;
		}
	}
	return $resultadoArray;
}

function dbToArrayHomolog($query){
	$find = $dbHomolog->prepare ( $query );
	$find->execute ();
	$resultado = $find->fetchAll ( PDO::FETCH_NUM );
	$resultadoArray = array ();
	foreach ( $resultado as $values ) {
		foreach ( $values as $value ) {
			$resultadoArray [] = $value;
		}
	}
	return $resultadoArray;
}