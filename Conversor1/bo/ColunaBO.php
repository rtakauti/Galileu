<?php
//include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
//include_once 'BOImpl.php';
include_once 'PropriedadeBO.php';

class ColunaBO extends AssemblerBO{
	
	
	public function __construct() {}

	
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
				$lista[$schema][] = "\nALTER TABLE IF EXISTS $tabela DROP COLUMN IF EXISTS $coluna CASCADE;";
				unset ( parent::$result ['schema'] [$schema]['tabela'][$tabela]['coluna'] [$coluna] );
			}
			$schemas = array_keys($lista);
			foreach ($schemas as $schema) {
				$string .= "\n\nSET SEARCH_PATH TO $schema;";
				$string .= implode("", $lista[$schema]);
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	public function createColumn() {
		$sequence = $this->estrutura [EstruturaQuery::SEQUENCE];
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$schema = $this->estrutura [EstruturaQuery::SCHEMA];
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$fase = $this->fase;
		//$dev = $this->dao->propriedade(SchemaType::DEV);
		//$homolog = $this->dao->propriedade(SchemaType::HOMOLOG);
		//$colunas = array_diff_assoc($dev, $homolog);
		$homolog = $this->homologArray;
		$dev = $this->devArray;
		$colunas = array_diff(array_keys($dev), array_keys($homolog));
		$string = "";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $nomeColuna => $coluna ) {
				$propriedade = new PropriedadeBO ( $empresa, $schema, $tabela, $nomeColuna, $sequence, $fase, $coluna );
				//$propriedades = substr($propriedade->constructProperty (), 0, -1);
				$propriedades = $propriedade->constructProperty ();
				$string .= "\t$nomeColuna $propriedades ,\n";
			}
		}
		return $string;
	}
	
	public function addColumn(){
		$sequence = $this->estrutura [EstruturaQuery::SEQUENCE];
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$schema = $this->estrutura [EstruturaQuery::SCHEMA];
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$fase = FaseQuery::ADD;
		//$dev = $this->dao->propriedade(SchemaType::DEV);
		//$homolog = $this->dao->propriedade(SchemaType::HOMOLOG);
		//$colunas = array_diff_assoc($dev, $homolog);
		$homolog = $this->homologArray;
		$dev = $this->devArray;
		$colunas = array_diff(array_keys($dev), array_keys($homolog));
		$string ="";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $nomeColuna => $coluna ) {
				$string .= "\n\nALTER TABLE $tabela ADD COLUMN $nomeColuna ";
				$propriedade = new PropriedadeBO ( $empresa, $schema, $tabela, $nomeColuna, $sequence, $fase, $coluna );
				$string .= $propriedade->constructProperty () . ";\n";
			}
		}
		//$string = substr($string, 0, -1);
		return $string;
	}
	
public function alterColumn(){
		$sequence = $this->estrutura [EstruturaQuery::SEQUENCE];
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$schema = $this->estrutura [EstruturaQuery::SCHEMA];
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$fase = FaseQuery::ALTER;
		$devArray = $this->devArray;
		$homologArray = $this->homologArray;
		$diffArray = array_intersect_key($devArray, $homologArray);
		$colunas = array();
		foreach ($diffArray as $nomeColuna => $valor) {
			$colunas[$nomeColuna] =  array_diff_assoc($devArray[$nomeColuna], $homologArray[$nomeColuna]);
			$input[$nomeColuna] =  array_diff_assoc($homologArray[$nomeColuna], $devArray[$nomeColuna]);
		}
		$string ="";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $nomeColuna => $coluna ) {
				if(!empty($coluna)){
				$string .= "\n\n---- CAMPO $nomeColuna TABELA $tabela ----";
				$output = implode(', ', array_map(function ($v, $k) { return $k . " = " . (!isset($v)?'NULO':$v); }, $input[$nomeColuna], array_keys($input[$nomeColuna])));
				$string .= "\n---- ESTADO ANTERIOR $output ----";
				$propriedade = new PropriedadeBO ( $empresa, $schema, $tabela, $nomeColuna, $sequence, $fase, $coluna );
				$string .= $propriedade->constructProperty () . "\n";
				}
			}
		return $string;
		}
	}
	
}