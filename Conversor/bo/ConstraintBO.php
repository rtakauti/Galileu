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
		$constraintsDiff = array_diff(array_keys($homolog), array_keys($dev));
		$constraintsIntersect = array_intersect(array_keys($homolog), array_keys($dev));
		$string = "";
		if (!empty ( $constraintsDiff ) || !empty($constraintsIntersect)) {
		$string = "\n\n\n-------------------- DROP CONSTRAINT --------------------";
			foreach ( $constraintsDiff as $nameConstraint ) {
				$string .= "\nALTER TABLE $tabela DROP CONSTRAINT $nameConstraint;" ;
			}
			foreach ($constraintsIntersect as $nameConstraint) {
				if($homolog[$nameConstraint] != $dev[$nameConstraint]){
					$string .= "\nALTER TABLE $tabela DROP CONSTRAINT $nameConstraint;" ;
				}
			}
		}
		return $string;
	}
	
	public function createConstraint() {
		$fase = FaseQuery::CREATE;
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
	
	
	public function addConstraint() {
		$fase = FaseQuery::ADD;
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$homolog = $this->dao->restricao ( SchemaType::HOMOLOG );
		$dev = $this->dao->restricao ( SchemaType::DEV );
		$constraints = array_diff_assoc ( $dev, $homolog );
		$constraintsIntersect = array_intersect(array_keys($homolog), array_keys($dev));
		$string = "";
		if (!empty($constraints )) {
			$string = "\n\n\n-------------------- ADD CONSTRAINT --------------------";
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$restricao = new RestricaoBO ( $constraint, $fase );
				$string .= "\nALTER TABLE $tabela\n\tADD CONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ";\n";
			}
			foreach ($constraintsIntersect as $nameConstraint) {
				if($homolog[$nameConstraint] != $dev[$nameConstraint]){
					$string .= "\nALTER TABLE $tabela\n\tADD CONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ";\n";
				}
			}
		}
		return $string;
	}
}


