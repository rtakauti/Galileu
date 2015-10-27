<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
date_default_timezone_set ( 'America/Sao_Paulo' );

include_once realpath ( __DIR__ . '/../bo/estrutura/Estrutura.php' );

class Saida extends Estrutura{
	
	private $file;
	private $cmd;
	private $path;
	
	public function __construct($dbCompany, $cmd, $host) {
		$this->cmd = $cmd;
		try {
			$config = parse_ini_file ( __DIR__ . "/../connection/config/config.ini", true );
			if(!isset($host)) parent::$host = $config ['connection'] ['host'];
			else parent::$host = $host;
			parent::$user = $config ['connection'] ['user'];
			parent::setPass($config['connection']['pass']);
			parent::$dbHomolog = $config [$dbCompany] ['homolog'];
			parent::$dbDev = $config [$dbCompany] ['dev'];
			
			$this->path = __DIR__ . "/../scripts/" . $dbCompany . "." . date ( 'd' ) . "." . date ( 'm' ) . "." . date ( 'Y' );
			if (! is_dir ( $this->path )) {
				mkdir ( $this->path, 0777 );
			}
		} catch ( Exception $e ) {
			$e->getMessage ();
		}
		
		$assembler = new AssemblerBO();
		$this->abre();
	}
	
	public function __destruct(){
		if(is_resource($this->file)){
			$this->fecha();
		}
		$this->tela("\n\nfechando o arquivo de script...\n\n");
	}
	
	private function abre() {
		$homolog = parent::$dbHomolog;
		$this->file = fopen ( $this->path."/".$homolog.".Script.".date('d').".".date('m').".".date('Y')."_H".date('H')."m".date('i').".sql", "a+", 0 );
		$this->gravar("\n\n------------------ DATABASE: $homolog ------------------\n");
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
	
	
}