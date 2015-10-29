<?php
include_once 'estrutura/Estrutura.php';
class TriggerBO extends Estrutura {
	
	private static function dev() {
		return parent::$dev['triggers'];
	}
	
	
	private static function homolog() {
		return parent::$homolog['triggers'];
	}
	
	
	
	private function listarTrigger($triggers, $titulo) {
		$string = "";
		if (! empty ( $triggers )) {
			$string .= "\n\n\n";
			$string .= str_pad(" $titulo TRIGGERS ",50,"-",STR_PAD_BOTH);
			foreach ($triggers as $indice => $trigger) $string .= "\n\t--$indice--   $trigger" ;
		}
		return $string;
	}
	
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarTrigger(self::dev(), "DEV");
		$string .= $this->listarTrigger(self::homolog(), "HOMOLOG");
		return $string;
	}
	
	
	
	
	public function drop(){
		$dev = self::dev();
		$homolog = self::homolog();
		$triggers = array_diff ( $homolog, $dev );
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE TRIGGER ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $triggers as $triggerInput ) {
				list($schema, $tabela, $trigger) = explode(".", $triggerInput);
				$funcao = substr(parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
				$string .= "\nDROP TRIGGER IF EXISTS $trigger ON $schema.$tabela;";
				$string .= "\nDROP FUNCTION IF EXISTS $schema.$funcao;";
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
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $triggers as $trigger ) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$event_manipulation = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['event_manipulation'];
				$action_timing = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_timing'];
				$eventos = implode ( " OR ", $event_manipulation );
				$trigger_scope = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['trigger_scope'];
				$action_statement = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'];
				
				$string .= "\nCREATE TRIGGER $trigger";
				$string .= "\n\t$action_timing $eventos";
				$string .= "\n\tON $schema.$tabela";
				$string .= "\n\tFOR EACH $trigger_scope";
				$string .= "\n\t$action_statement;";
			}
		}
		return $string;
	}
	
	public  function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$triggers = array_intersect($dev, $homolog);
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n";
			$string .= str_pad(" ALTER DE TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $triggers as $trigger ) {
				list($schema, $tabela, $trigger) = explode(".", $trigger);
				$devTrigger = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger];
				$homologTrigger = parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger];
				if($devTrigger != $homologTrigger){
					$event_manipulation = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['event_manipulation'];
					$action_timing = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_timing'];
					$eventos = implode ( " OR ", $event_manipulation );
					$trigger_scope = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['trigger_scope'];
					$action_statement = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'];
					$funcao = substr(parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
						
					$string .= "\n\nDROP TRIGGER IF EXISTS $trigger ON $schema.$tabela;";
					$string .= "\nDROP FUNCTION IF EXISTS $schema.$funcao;";
					$string .= "\nCREATE TRIGGER $trigger";
					$string .= "\n\t$action_timing $eventos";
					$string .= "\n\tON $tabela";
					$string .= "\n\tFOR EACH $trigger_scope";
					$string .= "\n\t$action_statement;";
				}
			}
		}
		return $string;
	}
	
	
	
}







