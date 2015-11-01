<?php
class IndiceBO extends TabelaBO{
	
	
	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['indices'], "DEV INDICE");
		$string .= parent::lista(parent::$homolog['indices'], "HOMOLOG INDICE");
		return $string;
	}
	
	
	public function drop() {
		$indices = array_diff ( parent::$homolog['indices'], parent::$dev['indices'] );
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n".str_pad(" DROP DE INDICES ",100,"-",STR_PAD_BOTH);
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
		$indices = array_diff(parent::$dev['indices'],  parent::$homolog['indices']);
		$string = "";
		if (! empty ( $indices )) {
			$string .= "\n\n\n".str_pad(" CREATE DE INDICES ",100,"-",STR_PAD_BOTH);
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
		$indices = array_intersect(parent::$dev['indices'],  parent::$homolog['indices']);
		$string = $stringResult = "";
		if (! empty ( $indices )) {
			foreach ( $indices as $indiceInput ) {
				list($schema, $tabela, $indice) = explode(".", $indiceInput);
				$dev = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['indice'][$indice] ;
				$homolog = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['indice'][$indice] ;
				if ($dev != $homolog){
					$stringResult = "\n\n\n".str_pad(" ALTER DE INDICES ",100,"-",STR_PAD_BOTH);
					$colunas = implode(", ", $dev);
					$string .= "\n\nDROP INDEX IF EXISTS $schema.$indice;";
					
					$string .= "\n\nCREATE INDEX $indice";
					$string .= "\n\tON $schema.$tabela";
					$string .= "\n\tUSING btree";
					$string .= "\n\t($colunas);";
				}
			}
		}
		return $stringResult.$string;
	}
	
}

