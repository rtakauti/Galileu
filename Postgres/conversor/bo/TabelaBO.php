<?php
include_once __DIR__.'/../dao/daoImpl/TabelaDAOImpl.php';
include_once __DIR__.'/../enum/SchemasCompany.php';
include_once __DIR__.'/../enum/SchemaType.php';
include_once 'BOImpl.php';

class TabelaBO extends BOImpl{
	
	protected  $dao;
	private $sequence;
	private $createSequence;
	
	public function __construct($dbCompany, $queryParameter){
		$this->dao = new TableDAOImpl($dbCompany, $queryParameter);
		$this->sequence = new SequenceBO($dbCompany);
	}
	
	public function arrayTabelas(){
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if(!empty($homolog) && !empty($dev)){
			$array = array_diff_assoc ($homolog , $dev );
		}
		if(isset($array)){
		$array = array_keys ( $array );
		sort ( $array );
		//return $this->dao->estruturarArray("homolog");
		//return $this->dao->arrayDev();
		return $array;
		}
		
	}
	
	public function dropTableHomolog() {
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if (isset ( $homolog ) && isset ( $dev )) {
			$array = array_diff_assoc ( $homolog, $dev );
			ksort ( $array );
			$array = array_keys ( $array );
			$string = "\n\n------ DROP DE TABELAS ------";
			foreach ( $array as $value ) {
				$string .= "\nDROP TABLE $value CASCADE;";
			}
			return $string;
		}
	}
	
	public function createTableHomolog() {
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if (isset ( $homolog ) && isset ( $dev )) {
			$homologSequence = $this->sequence->arrayHomolog ();
			$array = array_diff_assoc ( $dev, $homolog );
			ksort ( $array );
			$keys = array_keys ( $array );
			$string = "\n\n------ CREATE DAS TABELAS ------";
			$arraySequence = array ();
			foreach ( $keys as $tabelas ) {
				$string .= "\nCREATE TABLE $tabelas ";
				$string .= "\n( ";
				foreach ( $dev [$tabelas] as $campo => $campos ) {
					$string .= "\n\t{$campos['column_name']} {$campos['udt_name']} ";
					if (isset ( $campos ['numeric_precision'] ) && $campos ['udt_name'] == "numeric") {
						$string .= "({$campos['numeric_precision']},{$campos['numeric_scale']}) ";
					}
					if (isset ( $campos ['character_maximum_length'] ) && $campos ['udt_name'] == "varchar") {
						$string .= "({$campos['character_maximum_length']}) ";
					}
					if ($campos ['is_nullable'] == "NO") {
						$string .= "NOT NULL ";
					}
					if (isset ( $campos ['column_default'] )) {
						$string .= "DEFAULT {$campos['column_default']} ";
						if (substr ( $campos ['column_default'], 0, strlen ( "nextval('" ) ) == "nextval('") {
							$fimSequence = strpos ( $campos ['column_default'], "':" ) - strlen ( "nextval('" );
							$sequence = substr ( $campos ['column_default'], strlen ( "nextval('" ), $fimSequence );
							if (! in_array ( $sequence, $homologSequence )) {
								$arraySequence [] = "\nCREATE SEQUENCE $sequence;";
							}
						}
					}
					$string .= ", ";
				}
				$string = substr ( $string, 0, - 2 ) . "\n);";
			}
			$stringSequence = "------ CREATE DE SEQUENCES ------";
			$arraySequence = array_unique ( $arraySequence );
			$this->createSequence = $arraySequence;
			$stringSequence .= implode ( "", $arraySequence );
			return $stringSequence . $string;
		}
	}
	
	
	public function alterTableDropColumnHomolog() {
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if (isset ($homolog ) && isset ($dev )) {
			$aux = array_intersect_assoc ($homolog,$dev );
			ksort ( $aux );
			$tabelas = array_keys ( $aux );
			$string = "\n\n------ DROP DAS COLUNAS ------";
			foreach ( $tabelas as $tabela ) {
				$dropColumn = array_diff_assoc ($homolog [$tabela],$dev [$tabela] );
				if (! empty ( $dropColumn )) {
					foreach ( $dropColumn as $campos => $campo ) {
						$string .= "\nALTER TABLE $tabela DROP COLUMN $campos CASCADE;";
					}
				}
			}
			return $string;
		}
	}
	
	public function alterTableAddColumnHomolog() {
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if (isset ($homolog ) && isset ($dev )) {
			$homologSequence = $this->sequence->arrayHomolog ();
			$aux = array_intersect_assoc ($homolog,$dev );
			ksort ( $aux );
			$tabelas = array_keys ( $aux );
			$string = "\n\n------ ADD DAS COLUNAS ------";
			foreach ( $tabelas as $tabela ) {
				$insertColumn = array_diff_assoc ($dev [$tabela],$homolog [$tabela] );
				if (! empty ( $insertColumn )) {
					foreach ( $insertColumn as $campo => $campos ) {
						$string .= "\nALTER TABLE $tabela ADD COLUMN $campo";
						$string .= "\n\t{$campos['udt_name']} ";
						if (isset ( $campos ['numeric_precision'] ) && $campos ['udt_name'] == "numeric") {
							$string .= "({$campos['numeric_precision']},{$campos['numeric_scale']}) ";
						}
						if (isset ( $campos ['character_maximum_length'] ) && $campos ['udt_name'] == "varchar") {
							$string .= "({$campos['character_maximum_length']}) ";
						}
						if ($campos ['is_nullable'] == "NO") {
							$string .= "\n\tNOT NULL ";
						}
						if (isset ( $campos ['column_default'] )) {
							$string .= "\n\tDEFAULT {$campos['column_default']} ";
							if (substr ( $campos ['column_default'], 0, strlen ( "nextval('" ) ) == "nextval('") {
								$fimSequence = strpos ( $campos ['column_default'], "':" ) - strlen ( "nextval('" );
								$sequence = substr ( $campos ['column_default'], strlen ( "nextval('" ), $fimSequence );
								if (! in_array ( $sequence, $homologSequence )) {
									if (! in_array ( $sequence, $this->createSequence )) {
										$arrayCreateSequence [] = "\nCREATE SEQUENCE $sequence;";
										$this->createSequence [] = "\nCREATE SEQUENCE $sequence;";
										$arraySetSequence [] = "\nSELECT setval('$sequence', MAX($campo)) FROM {$campos['table_name']};";
									}
								} else {
									$arraySetSequence [] = "\nSELECT setval('$sequence', MAX($campo)) FROM {$campos['table_name']};";
								}
							}
						}
						$string .= ";\n";
					}
				}
			}
			$createSequence = "\n\n------ CREATE DE SEQUENCES ------";
			$arrayCreateSequence = array_unique ( $arrayCreateSequence );
			$this->createSequence = array_unique ( $this->createSequence );
			$createSequence .= implode ( "", $arrayCreateSequence );
			$setSequence = "";
			if (isset ( $arraySetSequence )) {
				$setSequence = "\n\n------ SET DE SEQUENCES ------";
				$arraySetSequence = array_unique ( $arraySetSequence );
				$setSequence .= implode ( "", $arraySetSequence );
			}
			// return $arraySetSequence;
			return $createSequence . $string . $setSequence;
		}
	}
	
	public function alterTableAlterColumnHomolog() {
		$homolog = $this->dao->arrayHomolog();
		$dev = $this->dao->arrayDev();
		if (isset ($homolog ) && isset ($dev )) {
			$homologSequence = $this->sequence->arrayHomolog ();
			$aux = array_intersect_assoc ($homolog,$dev );
			ksort ( $aux );
			$tabelas = array_keys ( $aux );
			$string = "\n\n------ ALTER DAS COLUNAS ------";
			foreach ( $tabelas as $tabela ) {
				if ($homolog[$tabela] !=$dev [$tabela]) {
					foreach ($homolog [$tabela] as $campo => $campos ) {
						if (isset ($dev [$tabela] [$campo] )) {
							if ($homolog[$tabela] [$campo] !=$dev [$tabela] [$campo]) {
								$propriedade =$homolog [$tabela] [$campo];
								$homologPropriedade =$homolog [$tabela] [$campo];
								$devPropriedade =$dev [$tabela] [$campo];
								$diffPropriedade = array_diff ( $devPropriedade, $homologPropriedade );
								$string .= "\n\nALTER TABLE {$propriedade['table_name']}";
								if (isset ( $diffPropriedade ['column_default'] )) {
									$string .= "\n\tALTER COLUMN {$propriedade['column_name']} DROP DEFAULT, \n\tALTER COLUMN {$propriedade['column_name']} SET DEFAULT {$diffPropriedade['column_default']}, ";
									if (substr ( $diffPropriedade ['column_default'], 0, strlen ( "nextval('" ) ) == "nextval('") {
										$fimSequence = strpos ( $diffPropriedade ['column_default'], "':" ) - strlen ( "nextval('" );
										$sequence = substr ( $diffPropriedade ['column_default'], strlen ( "nextval('" ), $fimSequence );
										if (! in_array ( $sequence, $homologSequence )) {
											if (! in_array ( $sequence, $this->createSequence )) {
												$arrayCreateSequence [] = "\nCREATE SEQUENCE $sequence;";
												$this->createSequence [] = "\nCREATE SEQUENCE $sequence;";
												$arraySetSequence [] = "\nSELECT setval('$sequence', MAX($campo)) FROM {$campos['table_name']};";
											} 
										}else {
												$arraySetSequence [] = "\nSELECT setval('$sequence', MAX($campo)) FROM {$campos['table_name']};";
											}
									}
								}
								if (isset ( $diffPropriedade ['is_nullable'] )) {
									if ($diffPropriedade ['is_nullable'] == "NO") {
										$string .= "\n\tALTER COLUMN {$propriedade['column_name']} SET NOT NULL, ";
									} else {
										$string .= "\n\tALTER COLUMN {$propriedade['column_name']} DROP NOT NULL, ";
									}
								}
								if (isset ( $diffPropriedade ['data_type'] )) {
									$string .= "\n\tALTER COLUMN {$propriedade['column_name']} TYPE {$diffPropriedade['data_type']} USING {$propriedade['column_name']}::{$diffPropriedade['data_type']}, ";
								}
								if (isset ( $diffPropriedade ['character_maximum_length'] )) {
									$string .= "\n\tALTER COLUMN {$propriedade['column_name']} TYPE character varying({$diffPropriedade['character_maximum_length']}), ";
								}
								if (isset ( $diffPropriedade ['numeric_precision'] )) {
									if ($devPropriedade ['udt_name'] == "numeric") {
										$string .= "\n\tALTER COLUMN {$propriedade['column_name']} TYPE numeric({$diffPropriedade['numeric_precision']},{$diffPropriedade['numeric_scale']}), ";
									}
								}
							}
						}
					}
				}
			}
			$createSequence = "\n\n------ CREATE DE SEQUENCES ------";
			$arrayCreateSequence = array_unique ( $arrayCreateSequence );
			$this->createSequence = array_unique ( $this->createSequence );
			$createSequence .= implode ( "", $arrayCreateSequence );
			$setSequence = "";
			if (isset ( $arraySetSequence )) {
				$setSequence = "\n\n------ SET DE SEQUENCES ------";
				$arraySetSequence = array_unique ( $arraySetSequence );
				$setSequence .= implode ( "", $arraySetSequence );
			}
			$string =substr ( str_replace ( ", \n\n", "; \n\n", $string ), 0, - 2 ) . ";";
			return 	$createSequence . $string . $setSequence;
		}
		
	}
}