<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once 'PropriedadeBO.php';
include_once 'estrutura/Estrutura.php';

class ColunaBO extends Estrutura{

	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela]['coluna'] )) {
						$colunas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
						foreach ( $colunas as $coluna ) {
							$lista [] = "$schema.$tabela.$coluna";
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
					if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela]['coluna'] )) {
					$colunas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
						foreach ( $colunas as $coluna ) {
							$lista [] = "$schema.$tabela.$coluna";
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
			$string = "\n\n------ DEV COLUNAS ------";
			foreach ($lista as $coluna) {
				list($schema, $tabela, $coluna) = explode(".", $coluna);
				$string .= "\n\t-- $schema.$tabela.$coluna" ;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG COLUNAS ------";
			$i = 0;
			foreach ($lista as $coluna) {
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
	
	public function add(){
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		if((isset(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna'])))
			$dev = array_keys(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna']);
		if((isset(parent::$homolog ['schema'] [$schema] ['tabela'][$tabela]['coluna'])))
			$homolog = array_keys(parent::$homolog ['schema'] [$schema] ['tabela'][$tabela]['coluna']);
		$colunas = array_diff($dev, $homolog);
		$string ="";
		if (! empty ( $colunas )) {
			$propriedade = new PropriedadeBO ( );
			foreach ( $colunas as $coluna ) {
				parent::$coluna = $coluna;
				$lista[$coluna][] = $propriedade->add();
				parent::$result['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna] = parent::$dev['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
			}
			$colunas = array_keys($lista);
			foreach ($colunas as $coluna) {
				$string .= "\n\nALTER TABLE $schema.$tabela ADD COLUMN $coluna ";
				$string .= implode("", $lista[$coluna]).";\n";
			}
		}
		return $string;
	}
	
	
	public function alter() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
			$dev = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
		if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] )))
			$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] );
		$colunas = array_intersect ( $dev, $homolog );
		if (! empty ( $colunas )) {
			$string = "";
			foreach ( $colunas as $coluna ) {
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				parent::$coluna = $coluna;
				$propriedade = new PropriedadeBO ();
				$string .= $propriedade->alter ();
			}
			return $string;
		}
	}
	
}