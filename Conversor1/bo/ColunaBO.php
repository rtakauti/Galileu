<?php
include_once realpath (__DIR__.'/../dao/daoImpl/ColunaDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once 'BOImpl.php';
include_once 'PropriedadeBO.php';

class ColunaBO{
	
	//protected  $dao;
	private $estrutura;
	private $fase;
	private $devArray;
	private $homologArray;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $sequenceParameter, $fase, $devArray, $homologArray) {
		//$this->dao = new ColunaDAOImpl($dbCompany, $schemaParameter, $tableParameter, $fase);
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->fase = $fase;
		$this->devArray = $devArray;
		$this->homologArray = $homologArray;
	}

	public function dropColumn(){
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		//$dev = array_keys($this->dao->propriedade(SchemaType::DEV));
		//$homolog = array_keys($this->dao->propriedade(SchemaType::HOMOLOG));
		//$colunas = array_diff($homolog, $dev);
		$homolog = $this->homologArray;
		$dev = $this->devArray;
		$colunas = array_diff(array_keys($homolog), array_keys($dev));
		$string = "";
		if (! empty ( $colunas )) {
		$string = "\n\n\n-------------------- DROP COLUMN --------------------";
		$string .= "\n/*";
			foreach ( $colunas as $coluna ) {
				$string .= "\nALTER TABLE $tabela DROP COLUMN $coluna;";
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