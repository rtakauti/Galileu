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
$file = $dbnameHomolog . "_script.sql";

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
function logMessage($dbDev, $e, $dbnameDev, $dbnameHomolog) {
	$erroMsg = $e->getMessage ();
	$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', '{$erroMsg}', 'FALHA', now())" );
	echo $erroMsg;
}

// $schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public' and table_name = 'tabela1'";
$schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public'";
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
	/*
	 * echo "DEVELOP";
	 * echo $table;
	 * echo "<pre>";
	 * print_r ( $resultadoDev );
	 * echo "</pre>";
	 *
	 * echo "HOMOLOG";
	 * echo "<pre>";
	 * print_r ( $resultadoHomolog );
	 * echo "</pre>";
	 *
	 *
	 * foreach ($resultadoDev as $dentro){
	 * foreach ($dentro as $key => $value){
	 * echo $key." - ".$value."</br>";
	 * }
	 * echo "<hr>";
	 * }
	 */
	
	// Verifica se a quantidade de colunas das tabelas de Dev e Homolog são iguais
	$qtdDev = count ( $resultadoDev );
	$qtdHomolog = count ( $resultadoHomolog );
	
	// As tabelas tem a mesma quantidade de colunas
	/*
	 * if ($qtdDev - $qtdHomolog == 0) {
	 * echo "tabela de Dev e Homolog tem as mesma quantidade de colunas";
	 * $contador = $qtdDev;
	 * } else if ($qtdDev - $qtdHomolog > 0) {
	 * echo "tabela de Dev tem mais colunas que Homolog";
	 * $contador = $qtdDev;
	 * } else {
	 * echo "tabela de Homolog tem mais colunas que Dev";
	 * $contador = $qtdHomolog;
	 * }
	 * echo "<br/>";
	 */
	// Cria um arquivo com um comentario contendo a tabela analisada em questão
	$f = fopen ( $file, "a+", 0 );
	$tabelaScript = "\n\n\n-------------------------- TABELA: $table --------------------------\n\n\n";
	fwrite ( $f, $tabelaScript, strlen ( $tabelaScript ) );
	fclose ( $f );
	
	// Verificar se o nome da coluna da tabela Dev e Homolog são iguais e os atributos são iguais
	// não considerando a mesma posição onde se encontram
	for($i = 0; $i < count ( $resultadoDev ); $i ++) {
		$nomeColunaDevEscape = pg_escape_string ( $resultadoDev [$i] [0] );
		$nomeColunaDev = $resultadoDev [$i] [0];
		$existeCampo = false;
		for($j = 0; $j < count ( $resultadoHomolog ); $j ++) {
			// verifica se nome da coluna se é igual
			if ($nomeColunaDevEscape == $resultadoHomolog [$j] [0]) {
				// flag verifica se o campo com o nome na tabela principal existe na verificada
				$existeCampo = true;
				// propriedades a serem alteradas ou adicionadas
				$alterTable = array ();
				$script = "ALTER TABLE $table ";
				for($k = 0; $k < count ( $resultadoDev [$i] ); $k ++) {
					$attributeDevEscape = pg_escape_string ( $resultadoDev [$i] [$k] );
					$attributeHomologEscape = pg_escape_string ( $resultadoHomolog [$j] [$k] );
					$attributeDev =  $resultadoDev [$i] [$k];
					$attributeHomolog = $resultadoHomolog [$j] [$k];
					if ($attributeDev == $attributeHomolog) {
						echo $k . " - " . $attributeDev . " - " . $tableColumnAttrib [$k] . "<br/>";
						echo $k . " - " . $attributeHomolog . " - " . $tableColumnAttrib [$k] . "<br/>";
						// Salvar msg de campos iguais e sem modificação
						$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Sem modificacao Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| IGUAL', 'IGUAL', now())" );
					} else {
						echo $k . " - " . $attributeDev . " - " . $tableColumnAttrib [$k] . "<br/>";
						echo $k . " - " . $attributeHomolog . " - " . $tableColumnAttrib [$k] . "<br/>";
						
						// Implementar alter table
						switch ($k) {
							// column_default valor padrão esta diferente
							case COLUMN_DEFAULT :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape DROP DEFAULT" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA ao dropar o valor default da coluna $nomeColunaDevEscape da tabela $table" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração com sucesso
									$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeHomologEscape}| DEFAULT dropado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
									logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
								}
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev DROP DEFAULT";
								if (isset ( $attributeDev )) {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape SET DEFAULT $attributeDevEscape" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA setar valor DEFAULT Coluna |$nomeColunaDevEscape| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração com sucesso
										$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDevEscape}| DEFAULT setado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
									}
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET DEFAULT $attributeDev";
								}
								break;
							
							// is_nullable valor da coluna obrigatorio
							case IS_NULLABLE :
								if ($attributeDev == "NO") {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape SET NOT NULL" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA setar NOT NULL Coluna |$nomeColunaDevEscape| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de campo requerido com sucesso
										$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDevEscape}| NOT NULL setado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
									}
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET NOT NULL";
								} else {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape DROP NOT NULL" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA dropar NOT NULL Coluna |$nomeColunaDevEscape| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de campo NÃO requerido com sucesso
										$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDevEscape}| NOT NULL dropado com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
									}
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev DROP NOT NULL";
								}
								break;
							
							// data_type varchar, numeric,char, text...
							case DATA_TYPE :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape TYPE $attributeDevEscape USING $nomeColunaDevEscape::$attributeDevEscape" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA alterar TIPO DADO Coluna |$nomeColunaDevEscape| Tabela |$table|" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração de tipo de campo com sucesso
									$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDevEscape}| TIPO do DADO modificado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
								}
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE $attributeDev USING $nomeColunaDev::$attributeDev";
								break;
							
							// data_type varchar, numeric,char, text...
							case CHARACTER_MAXIMUM_LENGTH :
								try {
									$dbHomolog->beginTransaction ();
									$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape TYPE character varying($attributeDev)" );
									if (! $check) {
										$dbHomolog->rollBack ();
										throw new Exception ( "FALHA alterar LIMITE CARACTERES Coluna |$nomeColunaDevEscape| Tabela |$table|" );
									} else {
										$dbHomolog->commit ();
									}
									// salva msg de alteração de tamanho limite para carcteres do tipo varchar
									$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| TAMANHO LIMITE modificado com SUCESSO', 'MODIFICADO', now())" );
								} catch ( Exception $e ) {
									logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
								}
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE character varying($attributeDev)";
								break;
							
							// precisão de campos numericos não incluidos float, real ou money
							case NUMERIC_PRECISION :
								if ($resultadoDev [$i] [UDT_NAME] == 'numeric') {
									try {
										$dbHomolog->beginTransaction ();
										$check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape TYPE NUMERIC({$attributeDev}, {$resultadoDev [$i] [NUMERIC_SCALE]})" );
										if (! $check) {
											$dbHomolog->rollBack ();
											throw new Exception ( "FALHA alterar PRECISAO NUMERICA Coluna |$nomeColunaDevEscape| Tabela |$table|" );
										} else {
											$dbHomolog->commit ();
										}
										// salva msg de alteração de tamanho limite para carcteres do tipo varchar
										$dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDevEscape}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| PRECISAO modificada com SUCESSO', 'MODIFICADO', now())" );
									} catch ( Exception $e ) {
										logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
									}
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$attributeDev}, {$resultadoDev [$i] [NUMERIC_SCALE]})";
								}
								break;
							/*
							 * // precisão de escalar de campos numericos não incluidos float, real ou money
							 * case NUMERIC_SCALE :
							 * if ($resultadoDev [$i] [UDT_NAME] == 'numeric') {
							 * try {
							 * $dbHomolog->beginTransaction ();
							 * $check = $dbHomolog->query ( "ALTER TABLE $table ALTER COLUMN $nomeColunaDevEscape TYPE NUMERIC({$resultadoDev [$i] [NUMERIC_PRECISION]}, {$attributeDev})" );
							 * if (! $check) {
							 * $dbHomolog->rollBack ();
							 * throw new Exception ( "FALHA alterar PRECISAO ESCALAR Coluna |$nomeColunaDevEscape| Tabela |$table|" );
							 * } else {
							 * $dbHomolog->commit ();
							 * }
							 * // salva msg de alteração de tamanho limite para carcteres do tipo varchar
							 * $dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Modificada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| ESCALAR modificada com SUCESSO', 'MODIFICADO', now())" );
							 * } catch ( Exception $e ) {
							 * logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
							 * }
							 * $alterTable[] = "\n ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$resultadoDev [$i] [NUMERIC_PRECISION]}, {$attributeDev})";
							 * }
							 * break;
							 */
							default :
								;
								break;
						} // fecha switch
							  // Cria um arquivo com um comentario contendo o campo analisado em questão
					} // fecha if comparação de nome de campo
				}
				if (count ( $alterTable ) !== 0) {
					
					$f = fopen ( $file, "a+", 0 );
					$script = "-- CAMPO: $nomeColunaDev --------------------------\n\n" . $script;
					$script .= substr ( implode ( ", ", $alterTable ), 0 ) . ";\n\n";
					echo $script;
					fwrite ( $f, $script, strlen ( $script ) );
					fclose ( $f );
				}
			}
		} // fim do if se o nome são iguais
	} // fim do for $j
	  
	// se campo não existe com o mesmo nome adiciona
	if ($existeCampo == false) {
		try {
			$dbHomolog->beginTransaction ();
			$check = $dbHomolog->query ( "ALTER TABLE $table ADD COLUMN $nomeColunaDev timestamp with time zone" );
			if (! $check) {
				$dbHomolog->rollBack ();
				throw new Exception ( "FALHA adicionar Coluna |$nomeColunaDev| Tabela |$table|" );
			} else {
				$dbHomolog->commit ();
			}
			// salva msg de alteração de tamanho limite para carcteres do tipo varchar
			// $dbDev->query ( "insert into log_transicao(tb_origem, tb_destino, msg, status, data) values ('{$dbnameDev}', '{$dbnameHomolog}', 'Adicionada Coluna |{$nomeColunaDev}| Propriedade |{$tableColumnAttrib[$k]}| Valor |{$attributeDev}| adicionada com SUCESSO', 'ADICIONADA', now())" );
		} catch ( Exception $e ) {
			logMessage ( $dbDev, $e, $dbnameDev, $dbnameHomolog );
		}
	}
}
