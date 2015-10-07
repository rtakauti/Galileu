<?php
include_once __DIR__ . '/../dao/daoImpl/ConstraintDAOImpl.php';
include_once realpath ( __DIR__ . '/../enum/SchemasCompany.php' );
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once 'BOImpl.php';
include_once 'RestricaoBO.php';
class ConstraintBO extends BOImpl {
	protected $dao;
	protected $estrutura;
	protected $fase;
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		$this->dao = new ConstraintDAOImpl ( $dbCompany, $schemaParameter, $tableParameter, $fase );
		$this->estrutura [EstruturaQuery::TABELA] = $tableParameter;
		$this->estrutura [EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura [EstruturaQuery::COMPANY] = $dbCompany;
		$this->fase = $fase;
	}
	public function createConstraint() {
		$fase = FaseQuery::CREATE;
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$schema = $this->estrutura [EstruturaQuery::SCHEMA];
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$constraints = $this->dao->restricao ( SchemaType::HOMOLOG );
		$string = "";
		if (! empty ( $constraints )) {
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$restricao = new RestricaoBO ( $constraint, $fase );
				$string .= "CONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ",\n";
			}
		}
		// return $constraints;
		return $string;
	}
	public function homolog() {
		return $this->dao->restricao ( SchemaType::HOMOLOG );
	}
}


