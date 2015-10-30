<?php
include_once 'estrutura/Estrutura.php';
class ColunaBO extends Estrutura{

	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['colunas'], "DEV COLUNA");
		$string .= parent::lista(parent::$homolog['colunas'], "HOMOLOG COLUNA");
		return $string;
	}	
	
	public function drop(){
		$colunas = array_diff ( parent::$homolog['colunas'], parent::$dev['colunas'] );
		$string = "";
		if (! empty ( $colunas )) {
		$string .= "\n\n\n".str_pad(" DROP COLUMN ",100,"-",STR_PAD_BOTH);
		$string .= "\n/*\n";
			foreach ( $colunas as $colunaInput ) {
				list($schema, $tabela, $coluna) = explode(".", $colunaInput);
				$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela";
				$string .= "\n\tDROP COLUMN IF EXISTS $coluna;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	
	public function create() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		if((isset(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna'])))
			$colunas = array_keys(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna']);
		$string = "";
		if (! empty ( $colunas )) {
			$propriedade = new PropriedadeBO ();
			parent::$fase = FaseQuery::CREATE;
			foreach ( $colunas as $coluna ) {
				parent::$coluna = $coluna;
				$propriedades = $propriedade->construct();
				$string .= "\t$coluna $propriedades,\n";
			}
		}
		return $string;
	}
	
	
	public function add() {
		$tabelas = array_intersect ( parent::$dev['tabelas'], parent::$homolog['tabelas'] );
		$string = $stringResult = "";
		if (! empty ( $tabelas )) {
			$propriedade = new PropriedadeBO ();
			parent::$fase = FaseQuery::ADD;
			foreach ( $tabelas as $tabelaInput ) {
				list ( parent::$schema, parent::$tabela ) = explode ( ".", $tabelaInput );
				$schema = parent::$schema;
				$tabela = parent::$tabela;
				if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$dev = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				$colunas = array_diff ( $dev, $homolog );
				if (! empty ( $colunas )) {
					$stringResult = "\n\n\n".str_pad(" ADD COLUMN ",100,"-",STR_PAD_BOTH);
					foreach ( $colunas as $coluna ) {
						parent::$coluna = $coluna;
						$string .= "\n\nALTER TABLE $schema.$tabela ADD COLUMN $coluna ";
						$string .= $propriedade->construct().";";
					}
				}
			}
		}
		return $stringResult.$string;
	}
	
	
	public function alter() {
		$colunas = array_intersect ( parent::$dev['colunas'], parent::$homolog['colunas'] );
		$titulo = $valida = $string = $stringResult = "";
		if (! empty ( $colunas )) {
			$propriedade = new PropriedadeBO ();
			foreach ( $colunas as $colunaInput ) {
				list ( parent::$schema, parent::$tabela, parent::$coluna ) = explode ( ".", $colunaInput );
				$path = parent::$schema.parent::$tabela;
				$propriedades = $propriedade->alter ();
				if($propriedades != ""){
					if($valida != $path){
						$stringResult = "\n\n\n" . str_pad ( " ALTER COLUMN ", 100, "-", STR_PAD_BOTH );
						$valida = $path;
						$titulo = "\n\n\n--TABELA: $path";
					}
				}
				$string .= "$titulo$propriedades";
				$titulo = "";
			}
		}
		return $stringResult . $string;
	}
	
}