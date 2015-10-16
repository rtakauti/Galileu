<?php
include_once realpath (__DIR__.'/../dao/daoImpl/FuncaoDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'BOImpl.php';

class FuncaoBO extends BOImpl{
	
protected  $dao;
private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter){
		$this->dao = new FuncaoDAOImpl($dbCompany, $schemaParameter);
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
	}
	
	
	public function dropFuncao() {
		$schema = $this->estrutura[EstruturaQuery::SCHEMA];
		$homolog = $this->dao->funcao(SchemaType::HOMOLOG);
		$dev = $this->dao->funcao(SchemaType::DEV);
		$objetos =  array_diff_assoc($homolog, $dev);
		$string = "";
		if (! empty ( $objetos )) {
			$string = "\n\n\n--------------------  DROP DE FUNCTION, PROCEDURE, TRIGGER $schema -------------------- ";
			$string .= "\n/*";
			foreach ( $objetos as $nomeObjeto => $objeto ) {
				$parameter = $objeto['parameter'];
				$arrayParameter = explode(", ", $parameter);
				$stringParameter = "";
				if (isset($arrayParameter))
				foreach ($arrayParameter as $parameter) {
					$stringParameter .= substr($parameter, strpos($parameter, " ")+1).", ";
				}
				$stringParameter = substr($stringParameter,0,-2);
				if($objeto['return'] != "trigger") $string .= "\nDROP FUNCTION $nomeObjeto ($stringParameter);";
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