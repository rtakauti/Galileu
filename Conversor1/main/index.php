<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
ini_set("max_execution_time", 3000);
ini_set('memory_limit', '64M');
//ini_set('memory_limit', '-1');


include_once realpath ( __DIR__ . '/../output/Saida.php' );
include_once realpath ( __DIR__ . '/../dao/daoImpl/TriggerDAOImpl.php' );
function __autoload($classe) {
	if (file_exists ( __DIR__ . "/../bo/$classe.php" )) {
		include_once __DIR__ . "/../bo/$classe.php";
	}
}
$connection = "connection";
If (isset ( $argv [1] )) {
	$dbCompany = $argv [1];
	$cmd = true;
	If (isset ( $argv [2] )) {
		$connection = $argv [2];
	}
} elseif (isset ( $_GET ['empresa'] )) {
	$dbCompany = $_GET ['empresa'];
	if (isset ($_GET['connection'])) $connection = $_GET['connection'];
	$cmd = false;
} else {
	$dbCompany = "teste";
	$cmd = false;
}

$saida = new Saida ( $dbCompany, $cmd, $connection );
$schema = new SchemaBO ();
$sequence = new SequenceBO();
$funcao = new FuncaoBO();
$tabela = new TabelaBO();
$trigger = new TriggerBO();
$indice = new IndiceBO();
$coluna = new ColunaBO();
$constraint = new ConstraintBO();


AssemblerBO::devTree();
AssemblerBO::homologTree();
/*
$saida->gravar($schema->listar());
$saida->gravar($sequence->listar());
$saida->gravar($funcao->listar());
$saida->gravar($tabela->listar());
$saida->gravar($trigger->listar());
$saida->gravar($indice->listar());
$saida->gravar($coluna->listar());
$saida->gravar($constraint->listar());
*/

$saida->gravar($schema->drop());
$saida->gravar($sequence->drop());
$saida->gravar($funcao->drop());
$saida->gravar($tabela->drop());
$saida->gravar($trigger->drop());
$saida->gravar($indice->drop());
$saida->gravar($coluna->drop());
$saida->gravar($constraint->drop());

$saida->gravar($schema->create());
$saida->gravar($sequence->create());
$saida->gravar($tabela->create());
$saida->gravar($coluna->add());
$saida->gravar($coluna->alter());
$saida->gravar($indice->create());
$saida->gravar($funcao->create());
$saida->gravar($trigger->create());


$saida->gravar($constraint->add());
$saida->gravar($constraint->alter());

$saida->gravar($funcao->alter());
$saida->gravar($indice->alter());
$saida->gravar($trigger->alter());

?>