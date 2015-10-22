<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );

include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
class Saida {
	
	private $file;
	private $cmd;
	private $path;
	private $estrutura;
	
	public function __construct($dbCompany, $cmd) {
		$this->cmd = $cmd;
		date_default_timezone_set ( 'America/Sao_Paulo' );
		try {
			$config = parse_ini_file ( __DIR__ . "/../connection/config/config.ini", true );
			$this->estrutura [EstruturaQuery::COMPANY] = $dbCompany;
			$this->estrutura [EstruturaQuery::USER] = $config ['connection'] ['user'];
			$this->estrutura [EstruturaQuery::DBHOMOLOG] = $config [$dbCompany] ['homolog'];
			$this->estrutura [EstruturaQuery::DBDEV] = $config [$dbCompany] ['dev'];
			$this->path = __DIR__ . "/../scripts/" . $dbCompany . "." . date ( 'd' ) . "." . date ( 'm' ) . "." . date ( 'Y' );
			if (! is_dir ( $this->path )) {
				mkdir ( $this->path, 0777 );
			}
		} catch ( Exception $e ) {
			$e->getMessage ();
		}
		$estrutura = $this->estrutura;
		$assembler = new AssemblerBO($dbCompany, $estrutura);
		
		$this->abre();
		$this->gravarDataBase();
	}
	
	public function __destruct(){
		if(is_resource($this->file)){
			$this->fecha();
		}
		$this->tela("\n\nfechando o arquivo de script...\n\n");
	}
	
	private function abre() {
		$homolog = $this->estrutura[EstruturaQuery::DBHOMOLOG];
		$this->file = fopen ( $this->path."/".$homolog.".Script.".date('d').".".date('m').".".date('Y')."_H".date('H')."m".date('i').".sql", "a+", 0 );
	}
	
	private function fecha() {
		$string = "\n\n---------- COMMIT ----------";
		$string .= "\n--COMMIT;";
		$string .= "\n\n---------- ROLLBACK ----------";
		$string .= "\n--ROLLBACK;";
		$this->gravar($string);
		fclose ( $this->file );
	}
	
	private function tela($string){
		if ($this->cmd) {
			echo $string;
		} else {
			echo nl2br ( $string );
		}
	}
	
	
	public function gravar($string) {
		$this->tela($string);
		fwrite ( $this->file, $string, strlen ( $string ) );
	}
	
	private function gravarDataBase(){
		$homolog = $this->estrutura[EstruturaQuery::DBHOMOLOG];
		$this->gravar("\n\n------------------ DATABASE: $homolog ------------------\n");
	}
	
}