<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
class Conexao {
	private $conn;
	private $name;
	private $host;
	private $user;
	private $pass;
	public function __construct($schema, $host = "gdev.galileulog.com.br", $user = "postgres", $pass = "g@l1l3u2012") {
		$this->name = $schema;
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		
		try {
			$this->conn = new PDO ( "pgsql:dbname={$this->name};host={$this->host}", $this->user, $this->pass );
			$this->conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function __destruct() {
		$this->conn = null;
	}
	public function query($query) {
		$find = $this->conn->prepare ( $query );
		$find->execute ();
		$resultado = $find->fetchAll ( PDO::FETCH_NUM );
		$resultadoArray = array ();
		foreach ( $resultado as $values ) {
			foreach ( $values as $value ) {
				$resultadoArray [] = $value;
			}
		}
		return $resultadoArray;
	}
	public function queryAllAssoc($query) {
		$find = $this->conn->prepare ( $query );
		$find->execute ();
		return $find->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function queryAll($query) {
		$find = $this->conn->prepare ( $query );
		$find->execute ();
		return $find->fetchAll ( PDO::FETCH_NUM );
	}
	public function queryPrintAll($query) {
		echo "<pre>";
		print_r ( $this->queryAll ( $query ) );
		echo "</pre>";
		exit ();
	}
	public function queryPrintAllAssoc($query) {
		echo "<pre>";
		print_r ( $this->queryAllAssoc ( $query ) );
		echo "</pre>";
		exit ();
	}
}





