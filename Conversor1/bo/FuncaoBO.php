<?php
include_once 'estrutura/Estrutura.php';
class FuncaoBO extends Estrutura{
	
	
	
public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['funcoes'], "DEV FUNCTION");
		$string .= parent::lista(parent::$homolog['funcoes'], "HOMOLOG FUNCTION");
		return $string;
	}
	
	
	public function drop() {
		$funcoes = array_diff ( parent::$homolog['funcoes'], parent::$dev['funcoes'] );
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n".str_pad(" DROP DE FUNCTION ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $funcoes as $funcao ) $string .= "\nDROP FUNCTION IF EXISTS $funcao;";
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	public function create() {
		$funcoes = array_diff(parent::$dev['funcoes'], parent::$homolog['funcoes']);
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n".str_pad(" CREATE DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $funcoes as $funcaoInput ) {
				list($schema, $funcao) = explode(".", $funcaoInput);
				$string .= "\n\n".parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'].";";
			}
		}
		return $string;
	}
	
	public function alter(){
		$funcoes = array_intersect(parent::$dev['funcoes'], parent::$homolog['funcoes']);
		$string = $stringResult = "";
		if(!empty($funcoes)){
			foreach ($funcoes as $funcoesInput) {
				list($schema, $funcao) = explode(".", $funcoesInput);
				$dev = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$homolog = parent::$homolog ['schema'] [$schema] ['funcao'][$funcao]['create'];
				if($dev != $homolog){ 
					$stringResult = "\n\n\n".str_pad(" ALTER DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
					$string .= "\n\n$dev;";
				}
				
			}
		}
		return $stringResult.$string;
	}
	
}







