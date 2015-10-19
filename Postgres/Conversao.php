<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
include 'Constants.php';
include_once 'Conexao.php';
include_once 'Coluna.php';
include_once 'Constraint.php';
include_once 'Arquivo.php';

$homologSchema = "rubens_test";
if (isset ( $argv [1] ))
	$homologSchema = $argv [1];
if (isset ( $_GET ['homologSchema'] ))
	$homologSchema = $_GET ['homologSchema'];

$devSchema = "rubens_teste";
if (isset ( $argv [2] ))
	$devSchema = $argv [2];
if (isset ( $_GET ['devSchema'] ))
	$devSchema = $_GET ['devSchema'];

$dev = new Conexao ( $devSchema );
$homolog = new Conexao ( $homologSchema );

// Abre um arquivo para gravar
$nomeArquivo = $homologSchema . "Script.sql";
$arquivo = new Arquivo ( $nomeArquivo );
$arquivo->abre ();
$arquivo->gravar ( "\n\n\n------------- DATABASE: $homologSchema -------------\n\n\n" );

$resultadoTableDev = $dev->query ( $schemaQuery );
$resultadoTableHomolog = $homolog->query ( $schemaQuery );

// Lista de SEQUENCES
$sequencesDev = $dev->query ( $sequenceQuery );
$sequencesHomolog = $homolog->query ( $sequenceQuery );

// Dropar Sequences que em comparação ao Dev estejam à mais
$comparaListaSequence = array_diff ( $sequencesHomolog, $sequencesDev );
$arquivo->gravar ( "------ DROP DE SEQUENCES ------" );
if (isset ( $comparaListaSequence ))
	$arquivo->gravar ( "\nDROP SEQUENCE " . implode ( "\nDROP SEQUENCE ", $comparaListaSequence ) . "\n\n" );
	
	// loop das tabelas do schema
foreach ( $resultadoTableDev as $table ) {
	
	// Lista dos CAMPOS
	$resultadoDev = $dev->queryAll ( $colunaQuery . "'$table'" );
	$resultadoHomolog = $homolog->queryAll ( $colunaQuery . "'$table'" );
	
	// Cria um arquivo com um comentario contendo a tabela analisada em questão
	$arquivo->gravar ( "\n\n------------- TABELA: $table -------------\n\n" );
	
	//Dropar as CONSTRAINTS do Homolog que em comparação ao ambiente de desenvolvimento esta à mais
	$devConstraintArrayAssoc = $dev->queryAllAssoc ( $constraintQuery. "'$table'" );
	$homologConstraintArrayAssoc = $homolog->queryAllAssoc ( $constraintQuery. "'$table'" );
	$constraint = new Constraint ( $devConstraintArrayAssoc, $homologConstraintArrayAssoc, $table );
	$arquivo->gravar ( $constraint->dropConstraints () . "\n\n" );
	
	// Dropar COLUNAS do Homolog que em comparação ao ambiente de desenvolvimento esta à mais
	$devColunaArrayAssoc = $dev->queryAllAssoc($colunaQuery."'$table'");
	$homologColunaArrayAssoc = $homolog->queryAllAssoc($colunaQuery."'$table'");
	$coluna = new Coluna($devColunaArrayAssoc, $homologColunaArrayAssoc, $table);
	$arquivo->gravar ($coluna->dropColunas()."\n\n");
	
	
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
						if (isset ( $attributeHomolog )  && $k != DATA_TYPE) {
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
					$arquivo->gravar ( "-- SET DE SEQUENCE: $nomeColunaDev --" );
					$arquivo->gravar ( implode ( "", $setSequence ) . "\n\n" );
				}
				
				// Imprime as alterações ALTER COLUMN
				if (count ( $alterTable ) != 0) {
					$arquivo->gravar ( "-- CAMPO: $nomeColunaDev --\n-- ESTADO ANTERIOR: " . implode ( ", ", $anterior ) . "  -------\n" . $script );
					$arquivo->gravar ( implode ( ", ", $alterTable ) . ";\n\n" );
				}
			} else { // fim do if se o nome são iguais
				
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
									$addTable [1] = "\n\t DEFAULT  nextval('" . $sequence . "')";
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
				if ((count ( $setSequenceAdd ) == 2) && $existeCampo == 'nao' && @$comparaSequence != @$setSequence [1]) {
					$arquivo->gravar ( "-- SET DE SEQUENCE: $nomeColunaDev --" );
					$arquivo->gravar ( implode ( "", $setSequenceAdd ) . "\n\n" );
					$comparaSequence = @$setSequence [1];
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
					$arquivo->gravar ( $add );
				} // fecha if nome iguais
			}
		} // for de $j
	} // for de $i
} // fecha foreach
$arquivo->fecha ();
$dev = null;
$homolog = null;
