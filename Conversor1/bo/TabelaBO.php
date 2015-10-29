<?php
include_once 'estrutura/Estrutura.php';
class TabelaBO extends Estrutura{
	
	private static function dev() {
		return parent::$dev['tabelas'];
	}
	
	
	private static function homolog() {
		return parent::$homolog['tabelas'];
	}
	
	
	private function listarTabela($tabelas, $titulo) {
		$string = "";
		if (! empty ( $tabelas )) {
			$string .= "\n\n\n";
			$string .= str_pad(" $titulo TABELAS ",50,"-",STR_PAD_BOTH);
			foreach ($tabelas as $indice => $tabela) $string .= "\n\t--$indice--   $tabela";
		}
		return $string;
	}
	
	public function listar(){
		$string = "";
		$string .= $this->listarTabela(self::dev(), "DEV");
		$string .= $this->listarTabela(self::homolog(), "HOMOLOG");
		return $string;
	}
	
	
	public function drop(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_diff ( $homolog, $dev );
		$string = "";
		if(!empty($tabelas)){
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE TABLE ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ($tabelas as $tabela) {
				list($schema, $tabela) = explode(".", $tabela);
				$string .= "\nDROP TABLE IF EXISTS $schema.$tabela;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	
	public function create(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_diff($dev, $homolog);
		$string = "";
		$user = parent::$user;
		if(!empty($tabelas)){
			$coluna = new ColunaBO();
			$constraint = new ConstraintBO();
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE TABLE ",100,"-",STR_PAD_BOTH);
			foreach ($tabelas as $tabelaInput) {
				list($schema, $tabela) = explode(".", $tabelaInput);
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$string .= "\n\n\nCREATE TABLE $schema.$tabela";
				$string .="\n(\n";
				$string .= $coluna->create();
				$string .= $constraint->create();
				$string = substr($string, 0, -2);
				$string .= "\n)";
				$string .= "\nWITH (\n\tOIDS=FALSE\n);";
				$string .= "\nALTER TABLE $tabela \n\tOWNER TO $user;";
			}
			return $string;
		}
	}
	
	
}