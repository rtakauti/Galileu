<?php
//include_once realpath (__DIR__ . '/../dao/daoImpl/TriggerDAOImpl.php');
include_once realpath ( __DIR__ . '/../enum/SchemasCompany.php' );
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
//include_once 'BOImpl.php';

class TriggerBO extends AssemblerBO {
	
	
	public function __construct() {
	}
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela]['trigger'] )) {
						$triggers = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] );
						foreach ( $triggers as $trigger ) {
							$lista [] = "$schema.$tabela.$trigger";
						}
					}
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$lista = array ();
		$schemas = array_keys ( parent::$homolog ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela]['trigger'] )) {
						$triggers = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] );
						foreach ( $triggers as $trigger ) {
							$lista [] = "$schema.$tabela.$trigger";
						}
					}
				}
			}
		}
		return $lista;
	}
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV TRIGGERS ------";
			foreach ($lista as $trigger) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$string .= "\n\t-- $schema.$trigger" ;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG TRIGGERS ------";
			foreach ($lista as $trigger) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$string .= "\n\t-- $schema.$trigger" ;
			}
		}
		return $string;
	}
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarDev();
		$string .= $this->listarHomolog();
		return $string;
	}
	
	
	
	
	public function drop(){
		$dev = self::dev();
		$homolog = self::homolog();
		$triggers = array_diff ( $homolog, $dev );
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n-------------------- DROP TRIGGER --------------------";
			$string .= "\n/*";
			foreach ( $triggers as $trigger ) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$funcao = substr(parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
				$string .= "\nDROP TRIGGER IF EXISTS $trigger ON $tabela CASCADE;";
				$string .= "\nDROP FUNCTION IF EXISTS $funcao CASCADE;";
				$lista[$schema][] = $string; 
				unset ( parent::$result ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger] );
			}
			$schemas = array_keys($lista);
			foreach ($schemas as $schema) {
				$string .= "\n\nSET SEARCH_PATH TO $schema;";
				$string .= implode("", $lista[$schema]);
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$triggers = array_diff($dev, $homolog);
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n-------------------- CREATE TRIGGER --------------------";
			foreach ( $triggers as $trigger ) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$string .= "\nCREATE TRIGGER $schema.$trigger";
				$eventos = implode ( " OR ", $trigger ['event_manipulation'] );
				$string .= "\n\t{$trigger['action_timing']} $eventos";
				$string .= "\n\tON $tabela";
				$string .= "\n\tFOR EACH {$trigger['trigger_scope']}";
				$string .= "\n\t{$trigger['action_statement']};";
			}
		}
		return $string;
	}
}


