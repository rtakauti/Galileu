<?php
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once 'estrutura/Estrutura.php';

class SchemaBO extends Estrutura{
	
	
	
	public static function dev(){
		return array_keys(parent::$dev['schema']);
	}
	
	public static function homolog(){
		return array_keys(parent::$homolog['schema']);
	}
	
	
	public function listarDev(){
		$dev = self::dev();
		$string = "";
		if(!empty($dev)){
			$string = "\n\n------ DEV SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $dev )  ;
		}
		return $string;
	}
	
	public function listarHomolog(){
		$homolog = self::homolog();
		$string = "";
		if(!empty($homolog)){
			$string = "\n\n------ HOMOLOG SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $homolog )  ;
			return $string;
		}
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
		$schemas = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $schemas )) {
			$string = "\n\n\n\n------------------------------ DROP DE SCHEMAS ------------------------------";
			$string .= "\n/*";
			foreach ( $schemas as $schema ) {
				$string .= "\nDROP SCHEMA IF EXISTS $schema CASCADE;";
				unset ( parent::$result ['schema'] [$schema] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	public function setSchema($schemaName){
		$string = "\n\n-------------------- SET SCHEMA $schemaName --------------------";
		$string .= "\nSET SEARCH_PATH TO $schemaName;";
		return $string;
	}
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$schemas = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $schemas ))
			$string .= "\n\n\n------------------------------ CREATE SCHEMA ------------------------------";
			foreach ( $schemas as $schema ) {
				$string .= "\nCREATE SCHEMA $schema;";
				parent::$result ['schema'] [$schema] = "";
			}
		return $string;
	}
	
	public function alterSchema(){
		$dbCompany = $this->estrutura [EstruturaQuery::COMPANY];
		$schemas = $this->intersect_homolog_devQuery();
		$string = "";
		if (! empty ( $schemas ))
			foreach ( $schemas as $schema ) {
				$string .= "\n\n\n\n------------------------------ ALTER SCHEMA ------------------------------";
				$string .= $this->setSchema ( $schema );
				$sequence = new SequenceBO ( $dbCompany, $schema );
				$string .= $sequence->dropSequence ();
				$sequenceParameter = $sequence->diff_dev_homologQuery();
				$string .= $sequence->createSequence ();
				$tabela = new TabelaBO ( $dbCompany, $schema,$sequenceParameter, $this->estrutura );
				$string .= $tabela->dropTable();
				$string .= $tabela->createTable ();
				$string .= $tabela->alterTable();
				$funcao = new FuncaoBO($dbCompany, $schema);
				$string .= $funcao->dropFuncao();
				$string .= $funcao->createFuncao();
			}
		return $string;
	}
	
}