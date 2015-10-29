<?php
class IndiceBO extends TabelaBO{
	
	
	public static function dev() {
		$lista = array ();
		$tabelas = parent::dev ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] )) {
				$indices = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] );
				foreach ( $indices as $indice ) {
					$lista [] = "$schema.$tabela.$indice";
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
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] )) {
				$indices = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['indice'] );
				foreach ( $indices as $indice ) {
					$lista [] = "$schema.$tabela.$indice";
				}
			}
		}
		return $lista;
	}
	
	
	public function listarDev() {
		$indices = self::dev();
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DEV INDICES ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($indices as $indice) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$string .= "\n\t--$i--   $schema.$indice" ;
				$i++;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$indices = self::homolog();
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n";
			$string .= str_pad(" HOMOLOG INDICES ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($indices as $indice) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$string .= "\n\t--$i--   $schema.$indice" ;
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
		$dev = self::dev();
		$homolog = self::homolog();
		$indices = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE INDICES ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $indices as $indice ) {
				list($schema, $tabela, $indice) = explode(".", $indice);
				$string .= "\nDROP INDEX IF EXISTS $schema.$indice;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$indices = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE INDICES ",100,"-",STR_PAD_BOTH);
			foreach ( $indices as $indiceInput ) {
				list($schema, $tabela, $indice) = explode(".", $indiceInput);
				$colunas = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'][$indice] ;
				$colunas = implode(", ", $colunas);
				$string .= "\n\nCREATE INDEX $indice";
				$string .= "\n\tON $schema.$tabela";
				$string .= "\n\tUSING btree";
				$string .= "\n\t($colunas);";
			}
		}
		return $string;
	}
	
	public function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$indices = array_intersect($dev, $homolog);
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n";
			$string .= str_pad(" ALTER DE INDICES ",100,"-",STR_PAD_BOTH);
			foreach ( $indices as $indiceInput ) {
				list($schema, $tabela, $indice) = explode(".", $indiceInput);
				$devColunas = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'][$indice] ;
				$homologColunas = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['indice'][$indice] ;
				if ($devColunas != $homologColunas){
					$colunas = implode(", ", $devColunas);
					$string .= "\n\nDROP INDEX IF EXISTS $schema.$indice;";
					
					$string .= "\nCREATE INDEX $indice";
					$string .= "\n\tON $schema.$tabela";
					$string .= "\n\tUSING btree";
					$string .= "\n\t($colunas);";
				}
			}
		}
		return $string;
	}
	
	
	
}




