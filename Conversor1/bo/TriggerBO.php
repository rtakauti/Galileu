<?php
class TriggerBO extends TabelaBO {
	
	public static function dev() {
		$lista = array ();
		$tabelas = parent::dev ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] )) {
				$triggers = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] );
				foreach ( $triggers as $trigger ) {
					$lista [] = "$schema.$tabela.$trigger";
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$lista = array ();
		$tabelas = parent::homolog ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] )) {
				$triggers = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['trigger'] );
				foreach ( $triggers as $trigger ) {
					$lista [] = "$schema.$tabela.$trigger";
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
			$string .= "\n/*\n";
			foreach ( $triggers as $trigger ) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$funcao = substr(parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
				$stringTrigger = "\nDROP TRIGGER IF EXISTS $trigger ON $tabela CASCADE;";
				$stringTrigger .= "\nDROP FUNCTION IF EXISTS $funcao CASCADE;";
				$lista[$schema][] = $stringTrigger; 
			}
			$schemas = array_keys($lista);
			foreach ($schemas as $schema) {
				$string .= "\n\nSET SEARCH_PATH TO $schema;";
				$string .= implode("", $lista[$schema]);
			}
			$string .= "\n\n\n*/";
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
				$event_manipulation = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['event_manipulation'];
				$action_timing = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_timing'];
				$eventos = implode ( " OR ", $event_manipulation );
				$trigger_scope = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['trigger_scope'];
				$action_statement = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'];
				
				$string .= "\n\nCREATE TRIGGER $trigger";
				$string .= "\n\t$action_timing $eventos";
				$string .= "\n\tON $tabela";
				$string .= "\n\tFOR EACH $trigger_scope";
				$string .= "\n\t$action_statement;";
			}
		}
		return $string;
	}
}


