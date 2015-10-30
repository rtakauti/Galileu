<?php
include_once 'estrutura/Estrutura.php';
class TriggerBO extends Estrutura {
	
	
	
	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['triggers'], "DEV TRIGGER");
		$string .= parent::lista(parent::$homolog['triggers'], "HOMOLOG TRIGGER");
		return $string;
	}
	
	
	public function drop(){
		$triggers = array_diff ( parent::$homolog['triggers'], parent::$dev['triggers'] );
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n".str_pad(" DROP DE TRIGGER ",100,"-",STR_PAD_BOTH);
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
		$triggers = array_diff(parent::$dev['triggers'] , parent::$homolog['triggers']);
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n\n".str_pad(" CREATE DE TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $triggers as $triggerInput ) {
				list($schema, $tabela, $trigger) = explode(".", $triggerInput);
				$event_manipulation = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['event_manipulation'];
				$action_timing = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_timing'];
				$eventos = implode ( " OR ", $event_manipulation );
				$trigger_scope = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['trigger_scope'];
				$action_statement = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'];
				
				$string .= "\n\nCREATE TRIGGER $trigger";
				$string .= "\n\t$action_timing $eventos";
				$string .= "\n\tON $schema.$tabela";
				$string .= "\n\tFOR EACH $trigger_scope";
				$string .= "\n\t$action_statement;";
			}
		}
		return $string;
	}
	
	
	
	public  function alter(){
		$triggers = array_intersect(parent::$dev['triggers'] , parent::$homolog['triggers']);
		$string = $stringResult = "";
		if (!empty ( $triggers )) {
			foreach ( $triggers as $triggerInput ) {
				list($schema, $tabela, $trigger) = explode(".", $triggerInput);
				$dev = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger];
				$homolog = parent::$homolog ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger];
				if($dev != $homolog){
					$stringResult = "\n\n\n".str_pad(" ALTER DE TRIGGER ",100,"-",STR_PAD_BOTH);
					$event_manipulation = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['event_manipulation'];
					$action_timing = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_timing'];
					$eventos = implode ( " OR ", $event_manipulation );
					$trigger_scope = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['trigger_scope'];
					$action_statement = parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'];
					$funcao = substr(parent::$dev ['schema'] [$schema]['tabela'][$tabela]['trigger'] [$trigger]['action_statement'], strlen("EXECUTE PROCEDURE "));
						
					$string .= "\n\nDROP TRIGGER IF EXISTS $trigger ON $schema.$tabela;";
					//$string .= "\n\nDROP FUNCTION IF EXISTS $schema.$funcao;";
					$string .= "\n\nCREATE TRIGGER $trigger";
					$string .= "\n\t$action_timing $eventos";
					$string .= "\n\tON $tabela";
					$string .= "\n\tFOR EACH $trigger_scope";
					$string .= "\n\t$action_statement;";
				}
			}
		}
		return $stringResult.$string;
	}
	
	
	
}







