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
$schema = new SchemaBO ( $dbCompany, $estrutura );
$saida->gravarDataBase ();
//$funcao = new FuncaoDAOImpl($dbCompany);
$assembler = new AssemblerBO($dbCompany);
echo "<pre>";
//print_r($funcao->retorna(SchemaType::DEV));
print_r($assembler->schemaDrop());
//print_r($assembler->dev());
echo "</pre>";
//$schemaDAO = new SchemaDAOImpl("teste");
//$schemaBO = new SchemaBO(SchemasCompany::TESTE, $estrutura); 
//$tabela = new TableDAOImpl(SchemasCompany::TESTE, 'public');
//$tabelaBO = new TabelaBO(SchemasCompany::TESTE, 'public', NULL, NULL);
/*
$indice = new IndiceDAOImpl("teste");
$trigger = new TriggerDAOImpl("teste");
$constraint = new ConstraintDAOImpl("teste");
*/
echo "<pre>";
//print_r($schemaDAO->retorna(SchemaType::DEV));
//print_r($schemaDAO->retorna1(SchemaType::DEV));
//print_r($trigger->trigger(SchemaType::DEV));
//print_r($funcao->funcao(SchemaType::DEV));
//print_r($indice->index(SchemaType::DEV));
//print_r($constraint->restricao(SchemaType::DEV));
echo "</pre>";

//$saida->gravar ( $schema->listarSchema () );
//$saida->gravar ( $schema->dropSchema () );
/*
$saida->gravar ( $schema->createSchema () );
$saida->gravar ( $schema->alterSchema () );
*/


$saida->fecha ();
