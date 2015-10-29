<?php
include_once 'estrutura/Estrutura.php';
class FuncaoBO extends Estrutura{
	
	
	private static function dev() {
		return parent::$dev['funcoes'];
	}
	
	private static function homolog() {
		return parent::$homolog['funcoes'];
	}
	
	private function listarFuncao($funcoes, $titulo) {
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n";
			$string .= str_pad(" $titulo FUNCTIONS ",50,"-",STR_PAD_BOTH);
			foreach ($funcoes as $indice => $funcao) $string .= "\n\t--$indice--   $funcao";
		}
		return $string;
	}
	
	public function listar(){
		$string = "";
		$string .= $this->listarFuncao(self::dev(), "DEV");
		$string .= $this->listarFuncao(self::homolog(), "HOMOLOG");
		return $string;
	}
	
	
	public function drop() {
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				 $string .= "\nDROP FUNCTION IF EXISTS $schema.$funcao;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				$create = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$string .= "\n\n$create";
			}
		}
		return $string;
	}
	
	public function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_intersect($dev, $homolog);
		$string = "";
		if(!empty($funcoes)){
			$string .= "\n\n\n";
			$string .= str_pad(" ALTER DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ($funcoes as $funcoesInput) {
				list($schema, $funcao) = explode(".", $funcoesInput);
				$devCreate = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$homologCreate = parent::$homolog ['schema'] [$schema] ['funcao'][$funcao]['create'];
				if($devCreate != $homologCreate){
					$string .= "\n\nDROP FUNCTION IF EXISTS $schema.$funcao;";
					
					$string .= "\n\n$devCreate";
				}
			}
		}
		return $string;
	}
	
}







