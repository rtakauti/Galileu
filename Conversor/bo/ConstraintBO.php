<?php
include_once realpath (__DIR__ . '/../dao/daoImpl/ConstraintDAOImpl.php');
include_once realpath ( __DIR__ . '/../enum/SchemasCompany.php' );
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once 'BOImpl.php';
include_once 'RestricaoBO.php';

class ConstraintBO extends BOImpl {
	
	protected $dao;
	private $fase;
	private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		$this->dao = new ConstraintDAOImpl ( $dbCompany, $schemaParameter, $tableParameter, $fase );
		$this->fase = $fase;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
	}
	
	public function dropConstraint(){
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$homolog = $this->dao->restricao(SchemaType::HOMOLOG);
		$dev = $this->dao->restricao ( SchemaType::DEV );
		$constraints = array_diff_assoc($homolog, $dev);
		$string = "";
		if (isset ( $constraints )) {
		$string = "\n\n\n-------------------- DROP CONSTRAINT --------------------";
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$string .= "\nALTER TABLE $tabela DROP CONSTRAINT $nameConstraint;" ;
			}
		}
		return $string;
		
	}
	
	public function createConstraint() {
		$fase = $this->fase;
		$homolog = $this->dao->restricao(SchemaType::HOMOLOG);
		$dev = $this->dao->restricao ( SchemaType::DEV );
		$constraints = array_diff_assoc($dev, $homolog);
		$string = "";
		if (isset ( $constraints )) {
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$restricao = new RestricaoBO ( $constraint, $fase );
				$string .= "\tCONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ",\n";
			}
		}
		return $string;
	}
	
	// ADD CONSTRAINT
}


