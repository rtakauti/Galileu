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
	private $fase;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		$this->dao = new ConstraintDAOImpl ( $dbCompany, $schemaParameter, $tableParameter, $fase );
		$this->fase = $fase;
	}
	
	public function dropConstraint(){
		$homolog = $this->dao->restricao(SchemaType::HOMOLOG);
		$dev = $this->dao->restricao ( SchemaType::DEV );
		$constraints = array_diff_assoc($homolog, $dev);
		$string .= "\n\n\n-------------------- DROP CONSTRAINT --------------------";
		if (isset ( $constraints )) {
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$string .= "\nCONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ",\n";
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
	
}


