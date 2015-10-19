<?php
const COLUMN_NAME = 0;
const COLUMN_DEFAULT = 1;
const IS_NULLABLE = 2;
const DATA_TYPE = 3;
const CHARACTER_MAXIMUM_LENGTH = 4;
const NUMERIC_PRECISION = 5;
const NUMERIC_SCALE = 6;
const UDT_NAME = 7;
const DTD_IDENTIFIER = 8;


$dbnameDev = "rubens_teste";
$dbnameHomolog = "rubens_test";

$host = "gdev.galileulog.com.br";
$dbuser = "postgres";
$dbpass = "g@l1l3u2012";

$tableColumnAttrib = array (
		'column_name',
		'column_default',
		'is_nullable',
		'data_type',
		'character_maximum_length',
		'numeric_precision',
		'numeric_scale',
		'udt_name',
		'dtd_identifier'
);




/**
 *
 * @author Rubens Takauti
 * @param $dbDev -
 *        	Objeto PDO
 * @param $e -
 *        	Objeto de Exceção com msg customizada
 * @param $dbnameDev -
 *        	Nome do BD Dev utilizado
 * @param $dbnameHomolog -
 *        	Nome do BD Homolg utilizado
 *
 */
function logMessage($dbDev, Exception $e, $msg, $status, $dbnameDev, $dbnameHomolog) {
	if (isset ( $e )) {
		$msg = $e->getMessage ();
		$status = "FALHA";
	}
	$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', '{$msg}', '{$status}', now())" );
}



$schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public' and table_name = 'tabela3'";

try {
	$dbTablesDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbTablesHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
	
	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}

$findTableDev = $dbTablesDev->prepare ( $schemaQuery );
$findTableDev->execute ();
$resultadoTableDev = $findTableDev->fetchAll ( PDO::FETCH_NUM );

foreach ( $resultadoTableDev as $key => $tabela ) {
	$table = $tabela [0];
	$query = "select ";
	$query .= "	column_name	, ";
	$query .= "	column_default	, ";
	$query .= "	is_nullable	, ";
	$query .= "	data_type	, ";
	$query .= "	character_maximum_length	, ";
	$query .= "	numeric_precision	, ";
	$query .= "	numeric_scale	, ";
	$query .= "	udt_name	, ";
	$query .= "	dtd_identifier	 ";
	$query .= "from information_schema.columns where table_name = '{$table}'";
	
	$findDev = $dbDev->prepare ( $query );
	$findDev->execute ();
	$resultadoDev = $findDev->fetchAll ( PDO::FETCH_NUM );
	
	$findHomolog = $dbHomolog->prepare ( $query );
	$findHomolog->execute ();
	$resultadoHomolog = $findHomolog->fetchAll ( PDO::FETCH_NUM );
	
	echo "DEVELOP";
	echo $table;
	echo "<pre>";
	print_r ( $resultadoDev );
	echo "</pre>";
	
	echo "HOMOLOG";
	echo "<pre>";
	print_r ( $resultadoHomolog );
	echo "</pre>";
	
	
	// Verifica se a quantidade de colunas das tabelas de Dev e Homolog são iguais
	$qtdDev = count ( $resultadoDev );
	$qtdHomolog = count ( $resultadoHomolog );
	
	// As tabelas tem a mesma quantidade de colunas
	if ($qtdDev - $qtdHomolog == 0) {
		echo "tabela de Dev e Homolog tem as mesma quantidade de colunas";
		$contador = $qtdDev;
	} else if ($qtdDev - $qtdHomolog > 0) {
		echo "tabela de Dev tem mais colunas que Homolog";
		$contador = $qtdDev;
	} else {
		echo "tabela de Homolog tem mais colunas que Dev";
		$contador = $qtdHomolog;
	}
	// Verificar se o nome da coluna da tabela Dev e Homolog são iguais e os atributos são iguais
	// não considerando a mesma posição onde se encontram
	for($i = 0; $i < count ( $resultadoDev ); $i ++) {
		$nomeColunaDev = pg_escape_string ( $resultadoDev [$i] [0] );
		for($j = 0; $j < count ( $resultadoHomolog ); $j ++) {
			// verifica se nome da coluna se é igual
			if ($nomeColunaDev == $resultadoDev [$j] [0]) {
				for($k = 0; $k < count ( $resultadoDev [$i] ); $k ++) {
					$attributeDev = pg_escape_string ( $resultadoDev [$i] [$k] );
					$attributeHomolog = pg_escape_string ( $resultadoHomolog [$i] [$k] );
					if ($attributeDev == $attributeHomolog) {
						// echo $k . " - " . $attributeDev . " - " . $tableColumnAttrib [$k];
						// Salvar msg de campos iguais e sem modificação
						$status = "IGUAL";
						$msg = "Sem modificacao Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| IGUAL";
						logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
						//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Sem modificacao Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| IGUAL', 'IGUAL', now())" );
					} else {
						// echo $k . " - " . $attributeDev . " - " . $tableColumnAttrib [$k];
						// Implementar alter table
						$status = "MODIFICADO";
						switch ($k) {
							// column_default valor padrão esta diferente
							case COLUMN_DEFAULT :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev DROP DEFAULT" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA ao dropar o valor default da coluna $nomeColunaDev da tabela $table" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração com sucesso
									$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeHomolog}| DEFAULT dropado com SUCESSO";
									logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeHomolog}| DEFAULT dropado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
									logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
								}
								if (isset ( $attributeDev )) {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev SET DEFAULT $attributeDev" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA setar valor DEFAULT Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração com sucesso
										$msg =  "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| DEFAULT setado com SUCESSO";
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| DEFAULT setado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								}
								break;
							
							// is_nullable valor da coluna obrigatorio
							case IS_NULLABLE :
								
								if ($attributeDev == "NO") {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev SET NOT NULL" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA setar NOT NULL Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de campo requerido com sucesso
										$msg = 
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| NOT NULL setado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								} else {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev DROP NOT NULL" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA dropar NOT NULL Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de campo NÃO requerido com sucesso
										$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| NOT NULL dropado com SUCESSO";
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| NOT NULL dropado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								}
								break;
							
							// data_type varchar, numeric,char, text...
							case DATA_TYPE :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev TYPE $attributeDev USING $nomeColunaDev::$attributeDev" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA alterar TIPO DADO Coluna |$nomeColunaDev| Tabela |$table|" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração de tipo de campo com sucesso
									$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| TIPO do DADO modificado com SUCESSO";
									//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| TIPO do DADO modificado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
									logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
								}
								break;
							
							// data_type varchar, numeric,char, text...
							case CHARACTER_MAXIMUM_LENGTH :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev TYPE character varying($attributeDev)" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA alterar LIMITE CARACTERES Coluna |$nomeColunaDev| Tabela |$table|" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração de tamanho limite para carcteres do tipo varchar
									$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| TAMANHO LIMITE modificado com SUCESSO";
									//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| TAMANHO LIMITE modificado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
									logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
								}
								break;
							
							// precisão de campos numericos não incluidos float, real ou money
							case NUMERIC_PRECISION :
								if ($resultadoDev [$i] [DATA_TYPE] == 'numeric') {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$attributeDev}, {$resultadoDev [$i] [NUMERIC_SCALE]})" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA alterar PRECISAO NUMERICA Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de tamanho limite para carcteres do tipo varchar
										$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| PRECISAO modificada com SUCESSO";
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| PRECISAO modificada com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								}
								break;
							
							// precisão de escalar de campos numericos não incluidos float, real ou money
							case NUMERIC_SCALE :
								if ($resultadoDev [$i] [DATA_TYPE] == 'numeric') {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$resultadoDev [$i] [NUMERIC_PRECISION]}, {$attributeDev})" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA alterar PRECISAO ESCALAR Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de tamanho limite para carcteres do tipo varchar
										$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| ESCALAR modificada com SUCESSO";
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| ESCALAR modificada com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								}
								break;
							
							// precisão de escalar de campos numericos não incluidos float, real ou money
							case NUMERIC_SCALE :
								if ($resultadoDev [$i] [DATA_TYPE] == 'numeric') {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$resultadoDev [$i] [NUMERIC_PRECISION]}, {$attributeDev})" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA alterar PRECISAO ESCALAR Coluna |$nomeColunaDev| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de tamanho limite para carcteres do tipo varchar
										$msg = "Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| ESCALAR modificada com SUCESSO";
										//$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| ESCALAR modificada com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage($dbDev, $e, $msg, $status, $dbnameDev, $dbnameHomolog);
									}
								}
								break;
							
										
							default :
								;
								break;
						}
					}
				}
			}
		}
	}
}

