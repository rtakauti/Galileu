<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
include_once realpath ( __DIR__ . '/../output/Saida.php' );
//include_once realpath ( __DIR__ . '/../bo/sequence/GerenciadorSequence.php' );
function __autoload($classe) {
	if (file_exists ( __DIR__ . "/../bo/$classe.php" )) {
		include_once __DIR__ . "/../bo/$classe.php";
	}
}

If (isset ( $argv [1] )) {
	$empresa = $argv [1];
	$cmd = true;
} elseif (isset ( $_GET ['empresa'] )) {
	$empesa = $_GET ['empresa'];
	$cmd = false;
} else {
	$empresa = "teste";
	$cmd = false;
}

$saida = new Saida ( $empresa, $cmd );
$saida->open ();
$estrutura = $saida->estrutura();
$schema = new SchemaBO ( $empresa, $estrutura );
$saida->gravarDataBase ();

$saida->gravar ( $schema->listarDev () );
$saida->gravar ( $schema->listarHomolog () );
$saida->gravar ( $schema->dropSchema () );
$saida->gravar ( $schema->createSchema () );
$saida->gravar ( $schema->alterSchema () );

$saida->fecha ();
