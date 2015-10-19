<?php

$dbnameDev = "rubens_teste";
$dbnameHomolog = "rubens_test";

$host = "gdev.galileulog.com.br";
$dbuser = "postgres";
$dbpass = "g@l1l3u2012";


$schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public'";// and table_name = 'tabela3'";

try {
	$dbTablesDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbTablesHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );

	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}
$var1=array();
$findTableDev = $dbTablesDev->prepare ( $schemaQuery );
$findTableDev->execute ();
//$resultadoTableDev = $findTableDev->fetchAll ( PDO::FETCH_NUM );
while ($var =  $findTableDev->fetch ( PDO::FETCH_NUM )){
	$var1[] = $var[0];
}
echo "<pre>";
	print_r($var1);
	echo "</pre>";
	