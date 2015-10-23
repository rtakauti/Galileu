<?php
//include_once realpath(__DIR__.'/../dao/daoImpl/IndiceDAOImpl.php');
include_once realpath(__DIR__.'/../enum/SchemasCompany.php');
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
//include_once 'BOImpl.php';

class IndiceBO extends AssemblerBO{
	
	
	public function __construct(){
	}
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela]['indice'] )) {
						$indices = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] );
						foreach ( $indices as $indice ) {
							$lista [] = "$schema.$tabela.$indice";
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
					if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela]['indice'] )) {
						$indices = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] );
						foreach ( $indices as $indice ) {
							$lista [] = "$schema.$tabela.$indice";
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
			$string = "\n\n------ DEV INDICES ------";
			foreach ($lista as $indice) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$string .= "\n\t-- $schema.$indice" ;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG INDICES ------";
			foreach ($lista as $indice) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$string .= "\n\t-- $schema.$indice" ;
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
	
	
	
	public function drop() {
		$dev = self::dev();
		$homolog = self::homolog();
		$indices = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $indices )) {
			$string = "\n\n-------------------- DROP DE INDICES -------------------- ";
			$string .= "\n/*";
			foreach ( $indices as $indice ) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$lista[$schema][] = "\nDROP INDEX IF EXISTS $indice CASCADE;";
				unset ( parent::$result ['schema'] [$schema]['tabela'][$tabela]['indice'] [$indice] );
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
	
	
	
	public function createIndex() {
		$indices = $this->dao->index(SchemaType::DEV);
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$string = "";
		if (! empty ( $indices )) {
			$string = "\n\n\n--------------------  CREATE DE INDICES $tabela -------------------- ";
			foreach ( $indices as $key => $indice ) {
				$string .= "\n\nCREATE INDEX $key";
				$string .= "\n\tON $tabela";
				$string .= "\n\tUSING btree";
				$string .= "\n\t(".implode(", ", $indice).");";
			}
		}
		return $string;
	}
	
	public function retornahomolog(){
		return $this->dao->index(SchemaType::DEV);
		return array_diff( $this->arrayHomolog(),$this->arrayDev());
	}
	
}