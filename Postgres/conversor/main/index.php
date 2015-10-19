<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
include_once realpath ( __DIR__ . '/../output/Saida.php' );

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

$schema = new SchemaBO ( $empresa );
$schemasArray = $schema->arrayHomolog ();
$sequence = new SequenceBO ( $empresa );
$saida->gravarDataBase ();
$saida->gravar ( $schema->listarDev () );
$saida->gravar ( $schema->listarHomolog () );
$saida->gravar ( $schema->dropSchemaHomolog () );
$saida->gravar($schema->createSchemaHomolog());

echo "<pre>";
// print_r($schema->dropSchemaHomolog());
// print_r($schema->arrayHomolog());
echo "</pre>";

$saida->gravar ( $sequence->dropSequenceHomolog () );
foreach ( $schemasArray as $schemaNome ) {
	$saida->gravar ( $schema->setSchema ( $schemaNome ) );
	$tabela = new TabelaBO ( $empresa, $schemaNome);
	
	$saida->gravar ( $tabela->dropTableHomolog () );
	$saida->gravar ( $tabela->createTableHomolog () );
	$saida->gravar ( $tabela->alterTableDropColumnHomolog () );
	$saida->gravar ( $tabela->alterTableAddColumnHomolog () );
	$saida->gravar ( $tabela->alterTableAlterColumnHomolog () );
	$tabelasArray = $tabela->arrayTabelas();
	echo "<pre>";
	print_r($tabelasArray );
	// print_r($schema->arrayHomolog());
	echo "</pre>";
	if(isset($tabelasArray)){
	foreach ($tabelasArray as $tabelaNome) {
		$constraint = new ConstraintBO($empresa, $tabelaNome);
		$saida->gravar($constraint->dropConstraintHomolog());
		echo "<pre>";
		echo "<H1>DIFF</H1>";
		print_r($constraint->dropConstraintHomolog());
		echo "<H1>HOMOLOG</H1>";
		print_r($constraint->arrayHomolog());
		echo "<H1>DEV</H1>";
		print_r($constraint->arrayDev());
		echo "</pre>";
	}
	}
	
	echo "<pre>";
	 //print_r($tabela->alterTableAlterColumnHomolog ());
	// print_r($schema->arrayHomolog());
	echo "</pre>";
}

$saida->fecha ();
