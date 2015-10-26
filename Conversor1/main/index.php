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
	If (isset ( $argv [2] )) {
		$host = $argv [2];
	}
} elseif (isset ( $_GET ['empresa'] )) {
	$dbCompany = $_GET ['empresa'];
	$cmd = false;
} else {
	$dbCompany = "teste";
	$cmd = false;
}

$saida = new Saida ( $dbCompany, $cmd, $host = NULL );
$schema = new SchemaBO ();
$sequence = new SequenceBO();
$funcao = new FuncaoBO();
$tabela = new TabelaBO();
$trigger = new TriggerBO();
$indice = new IndiceBO();
$coluna = new ColunaBO();
$constraint = new ConstraintBO();
$propriedade = new PropriedadeBO();
$restricao = new RestricaoBO();

/*
$saida->gravar($schema->listar());
$saida->gravar($sequence->listar());
$saida->gravar($funcao->listar());
$saida->gravar($tabela->listar());
$saida->gravar($trigger->listar());
$saida->gravar($indice->listar());
$saida->gravar($coluna->listar());
$saida->gravar($constraint->listar());


$saida->gravar($schema->drop());
$saida->gravar($sequence->drop());
$saida->gravar($funcao->drop());
$saida->gravar($tabela->drop());
$saida->gravar($trigger->drop());
$saida->gravar($indice->drop());
$saida->gravar($coluna->drop());
$saida->gravar($constraint->drop());
*/
$saida->gravar($schema->create());
$saida->gravar($sequence->create());
$saida->gravar($tabela->create());
$saida->gravar($indice->create());
$saida->gravar($funcao->create());
$saida->gravar($trigger->create());

echo "<pre>";
print_r($tabela->create());
//print_r($propriedade->construct("public.tabela3.cd_codigo", FaseQuery::CREATE));
//print_r($restricao->construct("public.tabela3.pk_tabela3", FaseQuery::CREATE));
//print_r(SequenceBO::result());
//print_r(SchemaBO::result());
echo "<hr/>";
//print_r(AssemblerBO::homolog());
echo "<hr/>";
print_r(AssemblerBO::dev());
echo "</pre>";


