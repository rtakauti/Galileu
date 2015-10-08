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

$indice = new IndiceBO(SchemasCompany::TESTE, 'public', 'tabela3');
$coluna = new ColunaBO(SchemasCompany::TESTE, 'public', 'tabela3', NULL, FaseQuery::CREATE);
echo "<pre>";
//print_r ( $coluna->createColumn());
//print_r ( $indice->retornahomolog() );
//print_r($schema->intersect_homolog_devQuery());
echo "</pre>";


/*
foreach ( $schemasCreateTableArray as $schemaNome ) {
	$sequence = new SequenceBO ( $empresa, $schemaNome );
	$saida->gravar ( $sequence->dropSequenceHomolog () );
	$saida->gravar ( $sequence->createSequenceHomolog());
	$saida->gravar ( $schema->setSchema ( $schemaNome ) );
	$tabela = new TabelaBO ( $empresa, $schemaNome );
	$saida->gravar($tabela->createTable());
	$tabelasAddColumnArray = $tabela->createTableDev();
	echo "<pre>";
	//print_r ( $tabelasAddColumnArray );
	//print_r($schemaNome."Schema");
	echo "</pre>";
	/*
	foreach ($tabelasAddColumnArray as $tabelaNome) {
		$coluna = new ColunaBO($empresa, $schemaNome, $tabelaNome);
		$colunasAddPropriedadeArray = $coluna->createColumn();
		echo "<pre>";
		//print_r ( $colunasAddPropriedadeArray );
		//print_r($tabelaNome."Tabela");
		echo "</pre>";
		$saida->gravar($coluna->createColumn());
		
		foreach ($colunasAddPropriedadeArray as $colunaNome) {
			$propriedade = new PropriedadeBO($empresa, $schemaNome, $tabelaNome, $colunaNome);
			$saida->gravar($propriedade->createProperty());
			echo "<pre>";
			//print_r ( $propriedadeAddArray );
			//print_r($colunaNome."Coluna");
			echo "</pre>";
			//$geradorPropriedade = new GeradorPropriedade($propriedade, $array);
			
		}
		
		
	}
	
	
}
*/
$saida->fecha ();
