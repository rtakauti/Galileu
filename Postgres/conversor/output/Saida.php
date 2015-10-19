<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
class Saida {
	
	private $homolog;
	private $dev;
	private $file;
	private $cmd;
	private $path;
	
	public function __construct($dbCompany, $cmd) {
		$this->cmd = $cmd;
		date_default_timezone_set('America/Sao_Paulo');
		try {
			$config = parse_ini_file ( __DIR__."/../connection/config/config.ini", true );
			$this->homolog = $config [$dbCompany] ['homolog'];
			$this->dev = $config [$dbCompany] ['dev'];
			$this->path = __DIR__."/../scripts/".$dbCompany.".".date('d').".".date('m').".".date('Y');
			if (!is_dir ( $this->path )) {
				mkdir ( $this->path, 0777 );
			}
		} catch ( Exception $e ) {
			$e->getMessage ();
		}
	}
	
	public function __destruct(){
		if(is_resource($this->file)){
			$this->fecha();
		}
		$this->tela("\n\nfechando o arquivo de script...\n\n");
	}
	
	public function open() {
		$this->file = fopen ( $this->path."/".$this->homolog.".Script.".date('d').".".date('m').".".date('Y')."_H".date('H')."m".date('i').".sql", "a+", 0 );
	}
	
	public function fecha() {
		$this->gravar("\n\n---------- COMMIT ----------\n--COMMIT;\n\n---------- ROLLBACK ----------\n--ROLLBACK;");
		fclose ( $this->file );
	}
	
	public function tela($string){
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
	
	public function gravarDataBase(){
		$string =  "\n\n------------------ DATABASE: {$this->homolog} ------------------\n";
		$this->tela($string);
		fwrite ( $this->file, $string, strlen ( $string ) );
	}
	
}