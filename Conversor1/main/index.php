<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
include_once realpath ( __DIR__ . '/../output/Saida.php' );
//include_once realpath ( __DIR__ . '/../bo/sequence/GerenciadorSequence.php' );
include_once realpath ( __DIR__ . '/../dao/daoImpl/TriggerDAOImpl.php' );
function __autoload($classe) {
	if (file_exists ( __DIR__ . "/../bo/$classe.php" )) {
		include_once __DIR__ . "/../bo/$classe.php";
	}
}

If (isset ( $argv [1] )) {
	$dbCompany = $argv [1];
	$cmd = true;
} elseif (isset ( $_GET ['empresa'] )) {
	$dbCompany = $_GET ['empresa'];
	$cmd = false;
} else {
	$dbCompany = "test";
	$cmd = false;
}

$saida = new Saida ( $dbCompany, $cmd );
$schema = new SchemaBO ();
$sequence = new SequenceBO();

$saida->open ();
$saida->gravarDataBase ();
$saida->gravar($schema->listar());
$saida->gravar($sequence->listar());
$saida->gravar($schema->drop());

echo "<pre>";
print_r($schema->listar());
print_r($sequence->dropSequence());
print_r(AssemblerBO::homolog());
echo "<hr/>";
print_r(AssemblerBO::dev());
echo "</pre>";


$saida->fecha ();
