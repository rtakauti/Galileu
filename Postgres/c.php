<?php
const COLUMN_NAME = 0;
const COLUMN_DEFAULT = 1;
const IS_NULLABLE = 2;
const DATA_TYPE = 3;
const CHARACTER_MAXIMUM_LENGTH = 4;
const NUMERIC_PRECISION = 5;
const NUMERIC_SCALE = 6;
const UDT_NAME = 7;
const DTD_IDENTIFIER = 8;

$dbnameDev = "rubens_teste";
$dbnameHomolog = "rubens_test";
$file = $dbnameHomolog . "_script.sql";

$host = "gdev.galileulog.com.br";
$dbuser = "postgres";
$dbpass = "g@l1l3u2012";

$tableColumnAttrib = array (
		'column_name',
		'column_default',
		'is_nullable',
		'data_type',
		'character_maximum_length',
		'numeric_precision',
		'numeric_scale',
		'udt_name',
		'dtd_identifier' 
);

try {
	
	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbDev->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
	$dbHomolog->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}

$schemaQuery = "select distinct ";
$schemaQuery .= " table_name ";
$schemaQuery .= " from information_schema.columns ";
$schemaQuery .= " where table_schema = 'public' ";
$schemaQuery .= " and table_name = 'tabela3'";

$findTableDev = $dbDev->prepare ( $schemaQuery );
$findTableDev->execute ();
$resultadoTableDev = $findTableDev->fetchAll ( PDO::FETCH_NUM );

foreach ( $resultadoTableDev as $key => $tabela ) {
	$table = $tabela [0];
	$query = "select ";
	$query .= "	column_name	, ";
	$query .= "	column_default	, ";
	$query .= "	is_nullable	, ";
	$query .= "	data_type	, ";
	$query .= "	character_maximum_length	, ";
	$query .= "	numeric_precision	, ";
	$query .= "	numeric_scale	, ";
	$query .= "	udt_name	, ";
	$query .= "	dtd_identifier	 ";
	$query .= "from information_schema.columns where table_name = '{$table}'";
	
	$findDev = $dbDev->prepare ( $query );
	$findDev->execute ();
	$resultadoDev = $findDev->fetchAll ( PDO::FETCH_NUM );
	
	$findHomolog = $dbHomolog->prepare ( $query );
	$findHomolog->execute ();
	$resultadoHomolog = $findHomolog->fetchAll ( PDO::FETCH_NUM );
	
	// Verifica se a quantidade de colunas das tabelas de Dev e Homolog são iguais
	$qtdDev = count ( $resultadoDev );
	$qtdHomolog = count ( $resultadoHomolog );
	
	if ($qtdDev < $qtdHomolog)
		echo "tem mais colunas em homolog<br>";
	else
		echo "nao tem mais";
	for($i = 0; $i < count ( $resultadoHomolog ); $i ++) {
		$nomeColunaHomolog = $resultadoHomolog [$i] [0];
		$igual = "nao";
		for($j = 0; $j < count ( $resultadoDev ); $j ++) {
			$nomeColunaDev = $resultadoDev [$j] [0];
			//echo $nomeColunaHomolog." - ".$nomeColunaDev."<br>";
			// verifica se nome da coluna se é igual
			if ($nomeColunaHomolog == $nomeColunaDev) {
				$igual = "sim";
			}
		}
		if ($igual == "nao") echo "DROP $nomeColunaHomolog <br/>";
	}
}
	