<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
class Coluna{
	
	private $devColunaName;
	private $homologColunaName;
	private $table;
	 
	public function __construct($devColunaArrayAssoc, $homologColunaArrayAssoc, $table) {
		
		$this->table = $table;
		
		for ($i = 0; $i < count($devColunaArrayAssoc); $i++) {
			if(isset($devColunaArrayAssoc [$i] ['column_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_name'] = $devColunaArrayAssoc [$i] ['column_name'];
			if(isset($devColunaArrayAssoc [$i] ['column_default'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['column_default'] = $devColunaArrayAssoc [$i] ['column_default'];
			if(isset($devColunaArrayAssoc [$i] ['is_nullable'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['is_nullable'] = $devColunaArrayAssoc [$i] ['is_nullable'];
			if(isset($devColunaArrayAssoc [$i] ['data_type'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['data_type'] = $devColunaArrayAssoc [$i] ['data_type'];
			if(isset($devColunaArrayAssoc [$i] ['character_maximum_length'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['character_maximum_length'] = $devColunaArrayAssoc [$i] ['character_maximum_length'];
			if(isset($devColunaArrayAssoc [$i] ['numeric_precision'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_precision'] = $devColunaArrayAssoc [$i] ['numeric_precision'];
			if(isset($devColunaArrayAssoc [$i] ['numeric_scale'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['numeric_scale'] = $devColunaArrayAssoc [$i] ['numeric_scale'];
			if(isset($devColunaArrayAssoc [$i] ['udt_name'])) $devColunaName [$devColunaArrayAssoc [$i] ['column_name']] ['udt_name'] = $devColunaArrayAssoc [$i] ['udt_name'];
		}
		$this->devColunaName = $devColunaName;
		
		for ($i = 0; $i < count($homologColunaArrayAssoc); $i++) {
			if(isset($homologColunaArrayAssoc [$i] ['column_name'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['column_name'] = $homologColunaArrayAssoc [$i] ['column_name'];
			if(isset($homologColunaArrayAssoc [$i] ['column_default'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['column_default'] = $homologColunaArrayAssoc [$i] ['column_default'];
			if(isset($homologColunaArrayAssoc [$i] ['is_nullable'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['is_nullable'] = $homologColunaArrayAssoc [$i] ['is_nullable'];
			if(isset($homologColunaArrayAssoc [$i] ['data_type'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['data_type'] = $homologColunaArrayAssoc [$i] ['data_type'];
			if(isset($homologColunaArrayAssoc [$i] ['character_maximum_length'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['character_maximum_length'] = $homologColunaArrayAssoc [$i] ['character_maximum_length'];
			if(isset($homologColunaArrayAssoc [$i] ['numeric_precision'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['numeric_precision'] = $homologColunaArrayAssoc [$i] ['numeric_precision'];
			if(isset($homologColunaArrayAssoc [$i] ['numeric_scale'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['numeric_scale'] = $homologColunaArrayAssoc [$i] ['numeric_scale'];
			if(isset($homologColunaArrayAssoc [$i] ['udt_name'])) $homologColunaName [$homologColunaArrayAssoc [$i] ['column_name']] ['udt_name'] = $homologColunaArrayAssoc [$i] ['udt_name'];
		}
		$this->homologColunaName = $homologColunaName;
	}
	
	
	public function colunaPrintDev(){
		echo "<pre>";
		print_r ( $this->devColunaName  );
		echo "</pre>";
		exit ();
	}
	
	public function colunaPrintHomolog(){
		echo "<pre>";
		print_r ( $this->homologColunaName  );
		echo "</pre>";
		exit ();
	}
	
	public function dropColunas() {
		$comparaColuna = array_keys(array_diff_key($this->homologColunaName, $this->devColunaName));
		$scriptDropColuna = "------ DROP DE COLUNAS ------";
		if (isset ( $comparaColuna )){
			foreach ($comparaColuna as $value) {
				$scriptDropColuna .= "\nALTER TABLE ".$this->table." DROP COLUMN ".$value.";";
			}
			unset($comparaColuna);
		}
		return $scriptDropColuna;
	}
	
}