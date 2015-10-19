<?php
include 'Constants.php';
include_once 'Conexao.php';
include_once 'Constraint.php';
include_once 'Arquivo.php';

$db = "rubens_test";
$dev = new Conexao ( "rubens_teste" );
$homolog = new Conexao ( $db );

$devColunaArrayAssoc = $dev->queryAllAssoc ( $colunaQuery . "'tabela3'" );

for ($i = 0; $i < count($devColunaArrayAssoc); $i++) {
	if(isset($devColunaArrayAssoc [$i] ['column_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_name'] = $devColunaArrayAssoc [$i] ['column_name'];
	if(isset($devColunaArrayAssoc [$i] ['column_default'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_default'] = $devColunaArrayAssoc [$i] ['column_default'];
	if(isset($devColunaArrayAssoc [$i] ['is_nullable'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['is_nullable'] = $devColunaArrayAssoc [$i] ['is_nullable'];
	if(isset($devColunaArrayAssoc [$i] ['data_type'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['data_type'] = $devColunaArrayAssoc [$i] ['data_type'];
	if(isset($devColunaArrayAssoc [$i] ['character_maximum_length'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['character_maximum_length'] = $devColunaArrayAssoc [$i] ['character_maximum_length'];
	if(isset($devColunaArrayAssoc [$i] ['numeric_precision'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_precision'] = $devColunaArrayAssoc [$i] ['numeric_precision'];
	if(isset($devColunaArrayAssoc [$i] ['numeric_scale'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_scale'] = $devColunaArrayAssoc [$i] ['numeric_scale'];
	if(isset($devColunaArrayAssoc [$i] ['udt_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['udt_name'] = $devColunaArrayAssoc [$i] ['udt_name'];
	}
	$devColuna = $devColunaName;
	
	$devColunaArrayAssoc = $homolog->queryAllAssoc ( $colunaQuery . "'tabela3'" );
	
	for ($i = 0; $i < count($devColunaArrayAssoc); $i++) {
		if(isset($devColunaArrayAssoc [$i] ['column_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_name'] = $devColunaArrayAssoc [$i] ['column_name'];
		if(isset($devColunaArrayAssoc [$i] ['column_default'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_default'] = $devColunaArrayAssoc [$i] ['column_default'];
		if(isset($devColunaArrayAssoc [$i] ['is_nullable'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['is_nullable'] = $devColunaArrayAssoc [$i] ['is_nullable'];
		if(isset($devColunaArrayAssoc [$i] ['data_type'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['data_type'] = $devColunaArrayAssoc [$i] ['data_type'];
		if(isset($devColunaArrayAssoc [$i] ['character_maximum_length'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['character_maximum_length'] = $devColunaArrayAssoc [$i] ['character_maximum_length'];
		if(isset($devColunaArrayAssoc [$i] ['numeric_precision'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_precision'] = $devColunaArrayAssoc [$i] ['numeric_precision'];
		if(isset($devColunaArrayAssoc [$i] ['numeric_scale'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_scale'] = $devColunaArrayAssoc [$i] ['numeric_scale'];
		if(isset($devColunaArrayAssoc [$i] ['udt_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['udt_name'] = $devColunaArrayAssoc [$i] ['udt_name'];
	}
	$homologColuna = $devColunaName;
	
	$teste = array_keys(array_diff_assoc($homologColuna, $devColuna));
	
echo "<pre>";
print_r($teste);
echo "</pre>";
