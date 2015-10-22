<?php
//include_once realpath (__DIR__.'/../dao/daoImpl/FuncaoDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
//include_once 'BOImpl.php';

class FuncaoBO extends AssemblerBO{
	
	
	public function __construct(){
	}
	
	public static function dev() {
		$schemas = array_keys ( parent::$dev ['schema'] );
		$lista = array();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['funcao'] )) {
				$funcoes = array_keys ( parent::$dev ['schema'] [$schema] ['funcao'] );
				foreach ( $funcoes as $funcao ) {
					$lista [] = $funcao;
				}
			}
		}
		return $lista;
	}
	
	public static function homolog() {
		$schemas = array_keys ( parent::$homolog ['schema'] );
		$lista = array ();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['funcao'] )) {
				$funcoes = array_keys ( parent::$homolog ['schema'] [$schema] ['funcao'] );
				foreach ( $funcoes as $funcao ) {
					$lista [] = $funcao;
				}
			}
		}
		return $lista;
	}
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV FUNCTIONS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $lista );
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG FUNCTIONS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $lista );
		}
		return $string;
	}
	
	public function listar(){
		$string = "";
		$string .= $this->listarDev();
		$string .= $this->listarHomolog();
		return $string;
	}
	
	
	public function drop() {
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $funcoes )) {
			$string = "\n\n\n--------------------  DROP DE FUNCTION, PROCEDURE, TRIGGER -------------------- ";
			$string .= "\n/*";
			foreach ( $funcoes as $funcao ) {
				 $string .= "\nDROP FUNCTION IF EXISTS $funcao CASCADE;";
				 $schema = substr($funcao, 0, strpos($funcao, '.'));
				 unset ( parent::$homolog ['schema'] [$schema] ['funcao'] [$funcao] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	public function createFuncao() {
		$schema = $this->estrutura[EstruturaQuery::SCHEMA];
		$dev = $this->dao->funcao(SchemaType::DEV);
		$homolog = $this->dao->funcao(SchemaType::HOMOLOG);
		$funcoes =  array_diff_assoc($dev, $homolog);
		$string = "";
		if (! empty ( $funcoes )) {
			$string = "\n\n\n--------------------  CREATE DE FUNCTION, PROCEDURE, TRIGGER $schema -------------------- ";
			foreach ( $funcoes as $nomeFuncao => $funcao ) {
			$string .= "\n{$funcao['create']}";
			}
		}
		return $string;
	}
	
	
}