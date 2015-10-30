<?php
include_once 'estrutura/Estrutura.php';
class TabelaBO extends Estrutura{
	
	
	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['tabelas'], "DEV TABELA");
		$string .= parent::lista(parent::$homolog['tabelas'], "HOMOLOG TABELA");
		return $string;
	}
	
	
	public function drop(){
		$tabelas = array_diff ( parent::$homolog['tabelas'], parent::$dev['tabelas'] );
		$string = "";
		if(!empty($tabelas)){
			$string .= "\n\n\n".str_pad(" DROP DE TABLE ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ($tabelas as $tabela)$string .= "\nDROP TABLE IF EXISTS $tabela;";
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	
	public function create(){
		$tabelas = array_diff(parent::$dev['tabelas'], parent::$homolog['tabelas']);
		$string = "";
		if(!empty($tabelas)){
			$coluna = new ColunaBO();
			$constraint = new ConstraintBO();
			$string .= "\n\n\n".str_pad(" CREATE DE TABLE ",100,"-",STR_PAD_BOTH);
			foreach ($tabelas as $tabela) {
				list(parent::$schema, parent::$tabela) = explode(".", $tabela);
				$string .= "\n\n\nCREATE TABLE $tabela";
				$string .="\n(\n";
				$string .= $coluna->create();
				//$string .= $constraint->create();
				$string = substr($string, 0, -2);
				$string .= "\n);";
				//$string .= "\nWITH (\n\tOIDS=FALSE\n);";
				//$string .= "\nALTER TABLE ".parent::$tabela." \n\tOWNER TO ".parent::$user.";";
			}
			return $string;
		}
	}
	
	
}