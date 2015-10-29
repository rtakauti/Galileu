<?php
class ConstraintBO extends TabelaBO{
	
	
	public static function dev() {
		$lista = array ();
		$tabelas = parent::dev ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )) {
				$constraints = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
				foreach ( $constraints as $constraint ) {
					$lista [] = "$schema.$tabela.$constraint";
				}
			}
		}
		return $lista;
	}
	
	public static function homolog() {
		$lista = array ();
		$tabelas = parent::homolog ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )) {
				$constraints = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
				foreach ( $constraints as $constraint ) {
					$lista [] = "$schema.$tabela.$constraint";
				}
			}
		}
		return $lista;
	}
	
	
	public function listarDev() {
		$constraints = self::dev();
		$string = "";
		if (! empty ( $constraints )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DEV CONSTRAINTS ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($constraints as $constraint) {
				list($schema, $tabela, $constraint) = explode(".", $constraint);
				$string .= "\n\t--$i--   $schema.$tabela.$constraint" ;
				$i++;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$constraints = self::homolog();
		$string = "";
		if (! empty ( $constraints )) {
			$string .= "\n\n\n";
			$string .= str_pad(" HOMOLOG CONSTRAINTS ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($constraints as $constraint) {
				list($schema, $tabela, $constraint) = explode(".", $constraint);
				$string .= "\n\t--$i--   $schema.$tabela.$constraint" ;
				$i++;
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
		$dev = self::dev ();
		$homolog = self::homolog ();
		$constraints = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $constraints )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE CONSTRAINT ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $constraints as $constraint ) {
				list ( $schema, $tabela, $constraint ) = explode ( ".", $constraint );
				$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela";
				$string .= "\n\tDROP CONSTRAINT IF EXISTS $constraint;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] ))
			$constraints = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
		$string = "";
		if (! empty ( $constraints )) {
			$restricao = new RestricaoBO ();
			foreach ( $constraints as $constraint ) {
				parent::$constraint = $constraint;
				$restricoes = $restricao->construct ( );
				$string .= "\tCONSTRAINT $constraint $restricoes,\n";
			}
		}
		return $string;
	}
	
	
	public function add() {
		$dev = parent::dev ();
		$homolog = parent::homolog ();
		$tabelas = array_intersect ( $dev, $homolog );
		$string = "";
		$stringResult = "";
		if (! empty ( $tabelas )) {
			$restricao = new RestricaoBO ( );
			foreach ( $tabelas as $tabelaInput ) {
				list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )))
					$dev =  array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint']) ;
				if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )))
					$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint']);
				$constraints = array_diff ( $dev, $homolog );
				if (! empty ( $constraints )) {
					foreach ( $constraints as $constraint) {
						parent::$constraint = $constraint;
						$restricoes = $restricao->construct ( );
						if($restricoes != ""){
							$stringResult = "\n\n\n".str_pad(" ADD DE CONSTRAINT ",100,"-",STR_PAD_BOTH);
							$string .= "\n\nALTER TABLE $schema.$tabela";
							$string .= "\n\tADD CONSTRAINT $constraint $restricoes;";
						}
					}
				}
			}
		}
		return $stringResult.$string;
	}
	
	
	public function alter() {
		$dev = self::dev ();
		$homolog = self::homolog ();
		$constraints = array_intersect ( $dev, $homolog );
		$string = "";
		$stringResult = "";
		if (! empty ( $constraints )) {
			$restricao = new RestricaoBO ( );
			foreach ( $constraints as $constraintInput ) {
				list ( $schema, $tabela, $constraint ) = explode ( ".", $constraintInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$dev = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] [$constraint];
				$homolog = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] [$constraint];
				if ($dev != $homolog) {
					parent::$constraint = $constraint;
					$restricoes = $restricao->construct ();
					if ($restricoes != "") {
						$stringResult = "\n\n\n".str_pad(" ALTER DE CONSTRAINT ",100,"-",STR_PAD_BOTH);
						
						$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela";
						$string .= "\n\tDROP CONSTRAINT IF EXISTS $constraint;";
						
						$string .= "\n\nALTER TABLE $schema.$tabela";
						$string .= "\n\tADD CONSTRAINT $constraint $restricoes;";
					}
				}
			}
		}
		return $stringResult.$string;
	}
	
}

