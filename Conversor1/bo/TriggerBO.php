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
							$funcao = substr(parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
							$lista [] = "$schema.$tabela.$trigger.$funcao";
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
							$funcao = substr(parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
							$lista [] = "$schema.$tabela.$trigger.$funcao";
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
				list($schema, $tabela, $trigger, $funcao) = explode(".", $trigger);
				$string .= "\nDROP TRIGGER IF EXISTS $trigger ON $tabela CASCADE;";
				$string .= "\nDROP FUNCTION IF EXISTS $funcao CASCADE;";
				unset ( parent::$result ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	
	public function createTrigger() {
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$dev = $this->dao->trigger( SchemaType::DEV );
		$homolog = $this->dao->trigger( SchemaType::HOMOLOG );
		$triggers = array_diff_assoc($dev, $homolog);
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n-------------------- CREATE TRIGGER --------------------";
			foreach ( $triggers as $nameTrigger => $trigger ) {
				$string .= "\nCREATE TRIGGER $nameTrigger ";
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


