<?php
include_once realpath (__DIR__ . '/../enum/SchemasCompany.php');
include_once realpath (__DIR__ . '/../enum/SchemaType.php');
include_once realpath (__DIR__ . '/../enum/FaseQuery.php');
include_once realpath (__DIR__ . '/../enum/EstruturaQuery.php');
include_once realpath (__DIR__ .'/../to/GeradorPropriedades.php');
include_once realpath (__DIR__ .'/../to/propriedade/MaximoCharTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/NomeUdtTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/NuloTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PadraoTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoMantissaTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoNumericaTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoDataTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/TipoDadoTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/TipoIntervaloTO.php');
include_once 'sequence/GerenciadorSequence.php';
//include_once realpath (__DIR__ . '/../dao/daoImpl/PropriedadeDAOImpl.php');
//include_once 'BOImpl.php';

class PropriedadeBO {

	//protected  $dao;
	private $arrayColuna;
	private $objetos;
	private $estrutura;
	private $fase;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $columnParameter, $sequenceParameter, $fase, $arrayColuna){
		//$this->dao = new PropriedadeDAOImpl($dbCompany, $schemaParameter, $tableParameter, $columnParameter, $fase);
		$this->arrayColuna = $arrayColuna;
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::COLUNA] = $columnParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->fase = $fase;
		
		$this->objetos['column_default'] = new PadraoTO();
		$this->objetos['is_nullable'] = new NuloTO();
		$this->objetos['data_type'] = new TipoDadoTO();
		$this->objetos['character_maximum_length'] = new MaximoCharTO();
		$this->objetos['numeric_precision'] = new PrecisaoNumericaTO();
		$this->objetos['numeric_scale'] = new PrecisaoMantissaTO();
		$this->objetos['datetime_precision'] = new PrecisaoDataTO();
		$this->objetos['udt_name'] = new NomeUdtTO();
		$this->objetos['interval_type'] = new TipoIntervaloTO();
	}
	public function constructProperty() {
		$coluna = $this->estrutura [EstruturaQuery::COLUNA];
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$propriedadesBO = $this->objetos;
		$fase = $this->fase;
		$estrutura = $this->estrutura;
		$stringResult = "";
		$propriedades = $this->arrayColuna;
		$condicao = $propriedades;
		foreach ( $propriedades as $key => $valor ) {
			$string = GeradorPropriedades::gerarPropriedade ( $propriedadesBO [$key], $valor, $fase, $condicao, $estrutura );
			$stringResult .= $string;
		}
		return $stringResult;
	}


}