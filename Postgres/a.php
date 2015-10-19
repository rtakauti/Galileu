<?php
include 'Constants.php';
include_once 'Conexao.php';
include_once 'Constraint.php';
include_once 'Arquivo.php';

$db = "rubens_test";
$dev = new Conexao ( "rubens_teste" );
$homolog = new Conexao ( $db );

$devConstraintArrayAssoc = $dev->queryAllAssoc ( $constraintQuery . "'tabela3'" );

for($i = 0; $i < count ( $devConstraintArrayAssoc ); $i ++) {
	if (isset ( $devConstraintArrayAssoc [$i] ['constraint_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_name'] = $devConstraintArrayAssoc [$i] ['constraint_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['constraint_type'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_type'] = $devConstraintArrayAssoc [$i] ['constraint_type'];
	if (isset ( $devConstraintArrayAssoc [$i] ['column_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['column_name'] [] = $devConstraintArrayAssoc [$i] ['column_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['match_option'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['match_option'] = $devConstraintArrayAssoc [$i] ['match_option'];
	if (isset ( $devConstraintArrayAssoc [$i] ['update_rule'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['update_rule'] = $devConstraintArrayAssoc [$i] ['update_rule'];
	if (isset ( $devConstraintArrayAssoc [$i] ['delete_rule'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['delete_rule'] = $devConstraintArrayAssoc [$i] ['delete_rule'];
	if (isset ( $devConstraintArrayAssoc [$i] ['consrc'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['consrc'] = $devConstraintArrayAssoc [$i] ['consrc'];
	if (isset ( $devConstraintArrayAssoc [$i] ['foreign_table_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_table_name'] = $devConstraintArrayAssoc [$i] ['foreign_table_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['foreign_column_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_column_name'] = $devConstraintArrayAssoc [$i] ['foreign_column_name'];
}
$devteste = $devConstraintName;

$devConstraintArrayAssoc = $homolog->queryAllAssoc ( $constraintQuery . "'tabela3'" );

for($i = 0; $i < count ( $devConstraintArrayAssoc ); $i ++) {
	if (isset ( $devConstraintArrayAssoc [$i] ['constraint_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_name'] = $devConstraintArrayAssoc [$i] ['constraint_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['constraint_type'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_type'] = $devConstraintArrayAssoc [$i] ['constraint_type'];
	if (isset ( $devConstraintArrayAssoc [$i] ['column_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['column_name'] [] = $devConstraintArrayAssoc [$i] ['column_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['match_option'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['match_option'] = $devConstraintArrayAssoc [$i] ['match_option'];
	if (isset ( $devConstraintArrayAssoc [$i] ['update_rule'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['update_rule'] = $devConstraintArrayAssoc [$i] ['update_rule'];
	if (isset ( $devConstraintArrayAssoc [$i] ['delete_rule'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['delete_rule'] = $devConstraintArrayAssoc [$i] ['delete_rule'];
	if (isset ( $devConstraintArrayAssoc [$i] ['consrc'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['consrc'] = $devConstraintArrayAssoc [$i] ['consrc'];
	if (isset ( $devConstraintArrayAssoc [$i] ['foreign_table_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_table_name'] = $devConstraintArrayAssoc [$i] ['foreign_table_name'];
	if (isset ( $devConstraintArrayAssoc [$i] ['foreign_column_name'] ))
		$devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_column_name'] = $devConstraintArrayAssoc [$i] ['foreign_column_name'];
}
$homologteste = $devConstraintName;

$compara = array_diff_key ( $homologteste, $devteste );
$homoKeyDiff = array_keys( array_diff_key ( $homologteste, $devteste ));
$homoKey = array_keys($homologteste);
$devKey = array_keys($devteste);
$resultado = array_diff($homoKey,$homoKeyDiff);
$result = array_diff($devKey, $resultado);

//print_r(array_intersect($homoKey, $devKey));

print_r($homoKey);
echo "<br>";
print_r($devKey);
echo "<br>";

//print_r($devKey);

$intersect = array_diff ( array_keys($homologteste), array_keys( array_diff_key ( $homologteste, $devteste )) );

echo "<pre>";
print_r ( $intersect );
echo "</pre>";

foreach ( $homologteste as $key => $values ) {
	// asort($values);
	echo "<br/>" . $key . "-><br/>";
	foreach ( $values as $key => $value ) {
		if (is_array ( $value )) {
			asort ( $value );
			echo $key . " - " . implode ( ", ", $value ) . "<br>";
		} else {
			echo $key . " - " . $value . "<br>";
		}
	}
}

if ($devteste ['ck_igual'] == $homologteste ['ck_igual']) {
	echo "igual";
}












