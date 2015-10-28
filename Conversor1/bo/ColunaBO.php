<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once 'PropriedadeBO.php';
include_once 'estrutura/Estrutura.php';

class ColunaBO extends TabelaBO{

	
	public static function dev() {
		$lista = array ();
		$tabelas = parent::dev ();
		foreach ( $tabelas as $tabelaInput ) {
			list($schema, $tabela) = explode(".", $tabelaInput);
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )) {
				$colunas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				foreach ( $colunas as $coluna ) {
					$lista [] = "$schema.$tabela.$coluna";
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
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )) {
				$colunas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				foreach ( $colunas as $coluna ) {
					$lista [] = "$schema.$tabela.$coluna";
				}
			}
		}
		return $lista;
	}

	
	public function listarDev() {
		$colunas = self::dev();
		$string = "";
		if (! empty ( $colunas )) {
			$string = "\n\n------ DEV COLUNAS ------";
			foreach ($colunas as $coluna) {
				list($schema, $tabela, $coluna) = explode(".", $coluna);
				$string .= "\n\t-- $schema.$tabela.$coluna" ;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$colunas = self::homolog();
		$string = "";
		if (! empty ( $colunas )) {
			$string = "\n\n------ HOMOLOG COLUNAS ------";
			foreach ($colunas as $coluna) {
				list($schema, $tabela, $coluna) = explode(".", $coluna);
				$string .= "\n\t-- $schema.$tabela.$coluna" ;
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
		$colunas = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $colunas )) {
		$string = "\n\n\n-------------------- DROP DE COLUNAS --------------------";
		$string .= "\n/*";
			foreach ( $colunas as $coluna ) {
				list($schema, $tabela, $coluna) = explode(".", $coluna);
				$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela \n\tDROP COLUMN IF EXISTS $coluna CASCADE;";
				unset ( parent::$result ['schema'] [$schema]['tabela'][$tabela]['coluna'] [$coluna] );
			}
			$string .= "\n*/";
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
			foreach ( $colunas as $coluna ) {
				parent::$coluna = $coluna;
				$propriedades = $propriedade->create();
				$string .= "\t$coluna $propriedades,\n";
				parent::$result['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna] = parent::$dev['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
			}
		}
		return $string;
	}
	
	
	public function add() {
		$dev = parent::dev ();
		$homolog = parent::homolog ();
		$tabelas = array_intersect ( $dev, $homolog );
		if (! empty ( $tabelas )) {
			$string = "\n\n\n------------------------------ ALTER TABLE ADD COLUMN ------------------------------";
			$propriedade = new PropriedadeBO ();
			foreach ( $tabelas as $tabelaInput ) {
				list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$dev = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				$colunas = array_diff ( $dev, $homolog );
				if (! empty ( $colunas )) {
					foreach ( $colunas as $coluna ) {
						parent::$coluna = $coluna;
						$string .= "\n\nALTER TABLE $schema.$tabela ADD COLUMN $coluna ";
						$string .= $propriedade->add ();
						$string .= ";";
						parent::$result ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna] = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna];
					}
				}
			}
		}
		return $string;
	}
	
	
	public function alter() {
		$lista = array();
		$dev = parent::dev ();
		$homolog = parent::homolog ();
		$tabelas = array_intersect ( $dev, $homolog );
		if (! empty ( $tabelas )) {
			$propriedade = new PropriedadeBO ();
			$string = "\n\n\n------------------------------ ALTER TABLE ALTER COLUMN ------------------------------";
			foreach ( $tabelas as $tabelaInput ) {
				list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$dev = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
					$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
				$colunas = array_intersect ( $dev, $homolog );
				if (! empty ( $colunas )) {
					foreach ( $colunas as $coluna ) {
						parent::$coluna = $coluna;
						$string .= $propriedade->alter ();
						parent::$result ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna] = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna];
					}
				}
				$string .= "\n";
			}
		}
		return $string;
	}
	
}