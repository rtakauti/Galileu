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

try {
	
	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbDev->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
	$dbHomolog->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}

$schemaQuery = "select distinct ";
$schemaQuery .= " table_name ";
$schemaQuery .= " from information_schema.columns ";
$schemaQuery .= " where table_schema = 'public' ";
$schemaQuery .= " and table_name = 'tabela3'";

$findTableDev = $dbDev->prepare ( $schemaQuery );
$findTableDev->execute ();
$resultadoTableDev = $findTableDev->fetchAll ( PDO::FETCH_NUM );

// Carga das sequences em um array
$sequenceQuery = "select ";
$sequenceQuery .= " relname ";
$sequenceQuery .= " from pg_class ";
$sequenceQuery .= " where relkind = 'S' ";
$sequenceQuery .= " and relnamespace in (select  ";
$sequenceQuery .= " 					oid ";
$sequenceQuery .= " 					from pg_namespace ";
$sequenceQuery .= " 					where nspname not like 'pg_%' ";
$sequenceQuery .= " 					and nspname != 'information_schema') ";

// Lista as sequences de Homolog
$findSequence = $dbHomolog->prepare ( $sequenceQuery );
$findSequence->execute ();
$resultadoSequence = $findSequence->fetchAll ( PDO::FETCH_NUM );
$sequencesHomolog = array ();
foreach ( $resultadoSequence as $values ) {
	foreach ( $values as $value ) {
		$sequencesHomolog [] = $value;
	}
}
// Lista as sequences de Dev
$findSequence = $dbDev->prepare ( $sequenceQuery );
$findSequence->execute ();
$resultadoSequence = $findSequence->fetchAll ( PDO::FETCH_NUM );
$sequencesDev = array ();
foreach ( $resultadoSequence as $values ) {
	foreach ( $values as $value ) {
		$sequencesDev [] = $value;
	}
}
unset ( $resultadoSequence );

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
	
	// Verifica se a quantidade de colunas das tabelas de Dev e Homolog são iguais
	$qtdDev = count ( $resultadoDev );
	$qtdHomolog = count ( $resultadoHomolog );
	
	// Cria um arquivo com um comentario contendo a tabela analisada em questão
	$f = fopen ( $file, "a+", 0 );
	$tabelaScript = "\n\n\n------------- DATABASE: $dbnameHomolog   TABELA: $table -------------\n\n\n";
	fwrite ( $f, $tabelaScript, strlen ( $tabelaScript ) );
	
	// Dropar colunas do Homolog que em comparação ao ambiente de desenvolvimento esta à mais
	$setDropColumn = array ();
	for($i = 0; $i < count ( $resultadoHomolog ); $i ++) {
		$nomeColunaHomolog = $resultadoHomolog [$i] [0];
		$igual = "nao";
		for($j = 0; $j < count ( $resultadoDev ); $j ++) {
			$nomeColunaDev = $resultadoDev [$j] [0];
			// echo $nomeColunaHomolog." - ".$nomeColunaDev."<br>";
			// verifica se nome da coluna se é igual
			if ($nomeColunaHomolog == $nomeColunaDev) {
				$igual = "sim";
			}
		} // fecha for $j
		if ($igual == "nao") {
			$setDropColumn [] = "\nALTER TABLE $table DROP COLUMN $nomeColunaHomolog;";
		}
	} // fecha for $i
	  // Imprime os DROP COLUMN
	if (count ( $setDropColumn ) != 0) {
		$scriptDropColumn = "------ DROP DE COLUNAS ------";
		// $scriptDropColumn .= "\nALTER TABLE $table ";
		$scriptDropColumn .= substr ( implode ( "", $setDropColumn ), 0 ) . "\n\n";
		echo nl2br ( $scriptDropColumn );
		fwrite ( $f, $scriptDropColumn, strlen ( $scriptDropColumn ) );
	}
	
	// Dropar Sequences que em comparação ao Dev estejam à mais
	$sequenceComparacao = array_diff ( $sequencesHomolog, $sequencesDev );
	$scriptDropSequence = "------ DROP DE SEQUENCES ------";
	foreach ( $sequenceComparacao as $value ) {
		$scriptDropSequence .= "\nDROP SEQUENCE $value;";
	}
	$scriptDropSequence .= "\n\n";
	echo nl2br ( $scriptDropSequence );
	fwrite ( $f, $scriptDropSequence, strlen ( $scriptDropSequence ) );
	
	// Verificar se o nome da coluna da tabela Dev e Homolog são iguais e os atributos são iguais
	// não considerando a mesma posição onde se encontram
	for($i = 0; $i < count ( $resultadoDev ); $i ++) {
		$nomeColunaDev = $resultadoDev [$i] [0];
		$existeCampo = "nao";
		$addTable = array ();
		$existePropriedade = 1;
		for($j = 0; $j < count ( $resultadoHomolog ); $j ++) {
			$setSequenceAdd = array ();
			// verifica se nome da coluna se é igual
			if ($nomeColunaDev == $resultadoHomolog [$j] [0]) {
				$setSequence = array ();
				// flag verifica se o campo com o nome na tabela principal existe na verificada
				$existeCampo = "existe";
				// propriedades a serem alteradas ou adicionadas
				$alterTable = array ();
				$anterior = array ();
				$script = "ALTER TABLE $table ";
				for($k = 0; $k < count ( $resultadoDev [$i] ); $k ++) {
					$verificaNome = $k;
					$attributeDev = $resultadoDev [$i] [$k];
					$attributeHomolog = $resultadoHomolog [$j] [$k];
					/*
					 *
					 * Altera colunas existentes que estam diferentes na tabela do schema de homologação
					 *
					 */
					if ($attributeDev != $attributeHomolog) {
						// Detalha o estado anterior do campo a ser alterado
						if (isset ( $attributeHomolog ) && $k != DTD_IDENTIFIER && $k != DATA_TYPE) {
							$anterior [] = $tableColumnAttrib [$k] . " = " . $attributeHomolog;
						} elseif ($k == COLUMN_DEFAULT) {
							$anterior [] = $tableColumnAttrib [$k] . " = null";
						}
						// Implementar alter table
						switch ($k) {
							// column_default valor padrão esta diferente
							case COLUMN_DEFAULT :
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev DROP DEFAULT";
								if (isset ( $attributeDev )) {
									// verfica se o valor default é relacionado a uma sequence
									if (substr ( $attributeDev, 0, strlen ( "nextval('" ) ) == "nextval('") {
										$fimSequence = strpos ( $attributeDev, "':" ) - strlen ( "nextval('" );
										// verifica se a sequence existe no schema de homolog
										$sequence = substr ( $attributeDev, strlen ( "nextval('" ), $fimSequence );
										if (in_array ( $sequence, $sequencesHomolog )) {
											$setSequence [] = "\nSELECT setval('$sequence', max($nomeColunaDev)) FROM $table;";
											$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET DEFAULT " . substr ( $attributeDev, 0, strpos ( $attributeDev, ":" ) ) . ")";
										} else {
											
											// criar a sequence com as configurações do schema de origem
											$setSequence [] = "\nCREATE SEQUENCE $sequence;";
											$setSequence [] = "\nSELECT setval('$sequence', max($nomeColunaDev)) FROM $table;";
											
											// atribuir a sequence gerada no campo destino
											$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET DEFAULT nextval('" . $sequence . "')";
										}
									} else {
										$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET DEFAULT $attributeDev";
									}
								}
								break;
							
							// is_nullable valor da coluna obrigatorio
							case IS_NULLABLE :
								if ($attributeDev == "NO") {
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev SET NOT NULL";
								} else {
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev DROP NOT NULL";
								}
								break;
							
							// data_type varchar, numeric,char, text...
							case DATA_TYPE :
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE $attributeDev USING $nomeColunaDev::$attributeDev";
								break;
							
							// data_type varchar, numeric,char, text...
							case CHARACTER_MAXIMUM_LENGTH :
								$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE character varying($attributeDev)";
								break;
							
							// precisão de campos numericos não incluidos float, real ou money
							case NUMERIC_PRECISION :
								if ($resultadoDev [$i] [UDT_NAME] == 'numeric') {
									$alterTable [] = "\n\t ALTER COLUMN $nomeColunaDev TYPE NUMERIC({$attributeDev},{$resultadoDev [$i] [NUMERIC_SCALE]})";
								}
								break;
							
							default :
								;
								break;
						} // fecha switch
					} // fecha if se atributo são iguais
				} // fecha for $k
				  
				// Imprime os sets das sequences
				if (count ( $setSequence ) != 0) {
					$scriptSequence = "-- SET DE SEQUENCE: $nomeColunaDev --";
					$scriptSequence .= substr ( implode ( "", $setSequence ), 0 ) . "\n\n";
					echo nl2br ( $scriptSequence );
					fwrite ( $f, $scriptSequence, strlen ( $scriptSequence ) );
				}
				
				// Imprime as alterações ALTER COLUMN
				if (count ( $alterTable ) != 0) {
					$script = "-- CAMPO: $nomeColunaDev --\n-- ESTADO ANTERIOR: " . substr ( implode ( ", ", $anterior ), 0 ) . "  -------\n" . $script;
					$script .= substr ( implode ( ", ", $alterTable ), 0 ) . ";\n\n";
					echo nl2br ( $script );
					fwrite ( $f, $script, strlen ( $script ) );
				}
			}else{  // fim do if se o nome são iguais
				
				/*
				 *
				 * Adiciona coluna na tabela se não existir ADD COLUMN
				 *
				 */
				$existePropriedade ++;
				$l = $existePropriedade - 1;
				if (isset ( $resultadoDev [$i] [$l] )) {
					$attributeDev = $resultadoDev [$i] [$l];
				}
				// echo $attributeDev;
				// Implementar alter table
				switch ($l) {
					// column_default valor padrão esta diferente
					case COLUMN_DEFAULT :
						if (isset ( $attributeDev ) && $resultadoDev [$i] [$l] != $resultadoHomolog [$i] [$l]) {
							// verfica se o valor default é relacionado a uma sequence
							if (substr ( $attributeDev, 0, strlen ( "nextval('" ) ) == "nextval('") {
								$fimSequence = strpos ( $attributeDev, "':" ) - strlen ( "nextval('" );
								// verifica se a sequence existe no schema de homolog
								$sequence = substr ( $attributeDev, strlen ( "nextval('" ), $fimSequence );
								// se existir a sequence no banco de dados de homolog
								if (in_array ( $sequence, $sequencesHomolog )) {
									$setSequenceAdd [1] = " ";
									$setSequenceAdd [2] = "\nSELECT setval('$sequence', max($nomeColunaDev)) FROM $table;";
									$addTable [1] = "\n\t DEFAULT existe " . substr ( $attributeDev, 0, strpos ( $attributeDev, ":" ) ) . ")";
								} else {
									// criar a sequence com as configurações do schema de origem
									$setSequenceAdd [1] = "\nCREATE SEQUENCE $sequence;";
									$setSequenceAdd [2] = "\nSELECT setval('$sequence', max($nomeColunaDev)) FROM $table;";
									// atribuir a sequence gerada no campo destino
									$addTable [1] = "\n\t DEFAULT nao nextval('" . $sequence . "')";
								}
							} else {
								$addTable [1] = "\n\t DEFAULT $attributeDev";
							}
						}
						break;
					
					// is_nullable valor da coluna obrigatorio
					case IS_NULLABLE :
						if ($attributeDev == "NO") {
							$addTable [2] = "\n\t NOT NULL";
						}
						break;
					
					// data_type varchar, numeric,char, text...
					case UDT_NAME :
						$tipo = "\n\t " . strtoupper ( $attributeDev );
						if (isset ( $resultadoDev [$i] [CHARACTER_MAXIMUM_LENGTH] )) {
							$tipo .= "({$resultadoDev [$i] [CHARACTER_MAXIMUM_LENGTH]})";
						}
						if ($resultadoDev [$i] [UDT_NAME] == 'numeric') {
							$tipo .= "({$resultadoDev [$i] [NUMERIC_PRECISION]},{$resultadoDev [$i] [NUMERIC_SCALE]})";
						}
						$addTable [0] = $tipo;
						break;
					default :
						;
						break;
				} // fecha switch
				// Imprime os sets das sequences
				if ((count ( $setSequenceAdd ) == 2)  && $existeCampo == 'nao' &&  $comparaSequence != @$setSequence[1]) {
					$scriptSequence = "-- SET DE SEQUENCE: $nomeColunaDev --";
					$scriptSequence .= substr ( implode ( "", $setSequenceAdd ), 0 ) . "\n\n";
					echo nl2br ( $scriptSequence );
					fwrite ( $f, $scriptSequence, strlen ( $scriptSequence ) );
					$comparaSequence = @$setSequence[1];
				}
				
				// Imprime as alterações ADD COLUMN
				if (($existeCampo == 'nao') && $existePropriedade == count ( $tableColumnAttrib )) {
					$add = "-- CAMPO: $nomeColunaDev --\n";
					$add .= "ALTER TABLE $table ADD COLUMN $nomeColunaDev ";
					for($m = 0; $m < count ( $addTable ); $m ++) {
						if (isset ( $addTable [$m] )) {
							$add .= $addTable [$m];
						}
					}
					$add .= ";\n\n";
					echo nl2br ( $add );
					fwrite ( $f, $add, strlen ( $add ) );
				}//fecha if nome iguais 
			}
		} // for de $j
	} // for de $i
} // fecha foreach
fclose ( $f );
$dbDev = null;
$dbHomolog = null;
