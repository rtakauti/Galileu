<?php
class Constraint {
	
	private $devConstraintName;
	private $homologConstraintName;
	private $table;
	
	
	public function __construct($devConstraintArrayAssoc, $homologConstraintArrayAssoc, $table) {
		
		$this->table = $table;
		
		for($i = 0; $i < count ( $devConstraintArrayAssoc ); $i ++) {
			if(isset($devConstraintArrayAssoc [$i] ['constraint_name'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_name'] = $devConstraintArrayAssoc [$i] ['constraint_name'];
			if(isset($devConstraintArrayAssoc [$i] ['constraint_type'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_type'] = $devConstraintArrayAssoc [$i] ['constraint_type'];
			if(isset($devConstraintArrayAssoc [$i] ['column_name'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['column_name'] [] = $devConstraintArrayAssoc [$i] ['column_name'];
			if(isset($devConstraintArrayAssoc [$i] ['match_option'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['match_option'] = $devConstraintArrayAssoc [$i] ['match_option'];
			if(isset($devConstraintArrayAssoc [$i] ['update_rule'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['update_rule'] = $devConstraintArrayAssoc [$i] ['update_rule'];
			if(isset($devConstraintArrayAssoc [$i] ['delete_rule'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['delete_rule'] = $devConstraintArrayAssoc [$i] ['delete_rule'];
			if(isset($devConstraintArrayAssoc [$i] ['consrc'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['consrc'] = $devConstraintArrayAssoc [$i] ['consrc'];
			if(isset($devConstraintArrayAssoc [$i] ['foreign_table_name'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_table_name'] = $devConstraintArrayAssoc [$i] ['foreign_table_name'];
			if(isset($devConstraintArrayAssoc [$i] ['foreign_column_name'])) $devConstraintName [$devConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_column_name'] = $devConstraintArrayAssoc [$i] ['foreign_column_name'];
		}
		$this->devConstraintName = $devConstraintName;
		
		for($i = 0; $i < count ( $homologConstraintArrayAssoc ); $i ++) {
			if(isset($homologConstraintArrayAssoc [$i] ['constraint_name'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_name'] = $homologConstraintArrayAssoc [$i] ['constraint_name'];
			if(isset($homologConstraintArrayAssoc [$i] ['constraint_type'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['constraint_type'] = $homologConstraintArrayAssoc [$i] ['constraint_type'];
			if(isset($homologConstraintArrayAssoc [$i] ['column_name'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['column_name'] [] = $homologConstraintArrayAssoc [$i] ['column_name'];
			if(isset($homologConstraintArrayAssoc [$i] ['match_option'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['match_option'] = $homologConstraintArrayAssoc [$i] ['match_option'];
			if(isset($homologConstraintArrayAssoc [$i] ['update_rule'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['update_rule'] = $homologConstraintArrayAssoc [$i] ['update_rule'];
			if(isset($homologConstraintArrayAssoc [$i] ['delete_rule'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['delete_rule'] = $homologConstraintArrayAssoc [$i] ['delete_rule'];
			if(isset($homologConstraintArrayAssoc [$i] ['consrc'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['consrc'] = $homologConstraintArrayAssoc [$i] ['consrc'];
			if(isset($homologConstraintArrayAssoc [$i] ['foreign_table_name'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_table_name'] = $homologConstraintArrayAssoc [$i] ['foreign_table_name'];
			if(isset($homologConstraintArrayAssoc [$i] ['foreign_column_name'])) $homologConstraintName [$homologConstraintArrayAssoc [$i] ['constraint_name']] ['foreign_column_name'] = $homologConstraintArrayAssoc [$i] ['foreign_column_name'];
		}
		$this->homologConstraintName = $homologConstraintName;
		
		
		
	}
	public function dropConstraints() {
		$comparaConstraint = array_keys(array_diff_key($this->homologConstraintName, $this->devConstraintName));
		$scriptDropConstraint = "------ DROP DE CONSTRAINTS ------";
		if (isset ( $comparaConstraint )){
			foreach ($comparaConstraint as $value) {
				$scriptDropConstraint .= "\nALTER TABLE ".$this->table." DROP CONSTRAINT ".$value.";";
			}
			unset($comparaConstraint);
		}
		return $scriptDropConstraint;
	}
	
	
	
	/*
	 * $chaves = array ();
	 * $tipoChaves = array ();
	 * for($i = 0; $i < count ( $resultadoDev ); $i ++) {
	 * $chaves [] = $resultadoDev [$i] [0];
	 * }
	 * //soma valores de key iguais
	 * $qtChaves = array_count_values ( $chaves );
	 *
	 * // formar as constraints da tabela secundaria
	 * $j = 0;
	 * $virgula = - 1;
	 * $scriptConstraint = "";
	 * $scriptDropConstraint = "";
	 * $constraintsDev = array();
	 * $constraintsDropDev = array();
	 * $referenceFK = "";
	 * foreach ( $qtChaves as $key => $value ) {
	 * $nomeConstraint = $key;
	 * $scriptDropConstraint .= "\nALTER TABLE $table DROP CONSTRAINT " . $nomeConstraint.";";
	 * $scriptConstraint .= "\nALTER TABLE $table\nADD CONSTRAINT " . $nomeConstraint;
	 * if ($resultadoDev [$j] [1] == "CHECK") {
	 * $scriptConstraint .= "\n" . $resultadoDev [$j] [1] . " " . $resultadoDev [$j] [7] . ";";
	 * $j ++;
	 * $virgula ++;
	 * } elseif ($resultadoDev [$j] [1] == "FOREIGN KEY") {
	 * $referenceFK .= "\nREFERENCES " . $resultadoDev [$j] [8] . " (" . $resultadoDev [$j] [9] . ")";
	 * if ($resultadoDev [$j] [4] != "NO ACTION") {
	 * $referenceFK .= "\nON UPDATE " . $resultadoDev [$j] [4];
	 * }
	 * if ($resultadoDev [$j] [5] != "NO ACTION") {
	 * $referenceFK .= "\nON DELETE " . $resultadoDev [$j] [5];
	 * }
	 * if ($resultadoDev [$j] [3] == "NONE") {
	 * $referenceFK .= "\nMATCH SIMPLE";
	 * }else{
	 * $referenceFK .= "\nMATCH " . $resultadoDev [$j] [3];
	 * }
	 * $referenceFK .= ";";
	 * $j ++;
	 * $virgula ++;
	 * } else {
	 * $scriptConstraint .= "\n" . $resultadoDev [$j] [1] . " (";
	 * $virgula += $value;
	 * for($i = 0; $i < $value; $i ++) {
	 * if ($virgula == $j) {
	 * $scriptConstraint .= $resultadoDev [$j] [2];
	 * } else {
	 * $scriptConstraint .= $resultadoDev [$j] [2] . ", ";
	 * }
	 * $j ++;
	 * }
	 * $scriptConstraint .= ");";
	 * } // fecha if verifica se igual a CHECK
	 * $scriptConstraint .= $referenceFK . "\n";
	 * $referenceFK = null;
	 * } // fecha foreach
	 * echo nl2br($scriptDropConstraint);
	 * echo nl2br ( $scriptConstraint );
	 * $constraintsDev = explode("\n\n", $scriptConstraint);
	 * $constraintsDropDev = explode("\n", substr($scriptDropConstraint, 1));
	 * echo "<pre>";
	 * print_r($constraintsDev);
	 * print_r($constraintsDropDev);
	 * echo "</pre>";
	 *
	 */
}