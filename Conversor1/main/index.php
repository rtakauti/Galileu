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
$saida->open ();
$estrutura = $saida->estrutura();
$schema = new SchemaBO ( $dbCompany, $estrutura,null );
$saida->gravarDataBase ();
$funcao = new FuncaoDAOImpl($dbCompany);
$assembler = new AssemblerBO($dbCompany);
echo "<pre>";
//print_r($funcao->retorna(SchemaType::DEV));
echo "<hr/>";
print_r($assembler->dev());
echo "</pre>";
/*
$saida->gravar ( $schema->createSchema () );
$saida->gravar ( $schema->alterSchema () );
*/


$saida->fecha ();
