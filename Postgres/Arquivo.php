<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
class Arquivo {
	private $nomeArquivo;
	private $file;
	public function __construct($nomeArquivo) {
		$this->nomeArquivo = $nomeArquivo;
	}
	public function abre() {
		$this->file = fopen ( $this->nomeArquivo, "a+", 0 );
	}
	public function fecha(){
		fclose($this->file);
	}
	function gravar($script) {
		echo nl2br ( $script );
		fwrite ( $this->file, $script, strlen ( $script ) );
	}
}