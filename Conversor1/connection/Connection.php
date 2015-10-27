<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
ini_set("max_execution_time", 3000);


include_once realpath ( __DIR__ . '/../bo/estrutura/Estrutura.php' );

class Connection extends Estrutura{
	
	private static $instances;
	
	private function __construct() {}
	
	
	public static function getInstances( ) {
		if (! isset ( self::$conns )) {
			try {
				$host = parent::$host;
				$user = parent::$user;
				$pass = parent::getPass();
				$dbDev = parent::$dbDev;
				$dbHomolog = parent::$dbHomolog;
				
				$connHomolog = new PDO ( "pgsql:dbname={$dbHomolog};host={$host}", $user, $pass );
				$connHomolog->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				
				$connDev = new PDO ( "pgsql:dbname={$dbDev};host={$host}", $user, $pass );
				$connDev->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				
			} catch ( Exception $e ) {
				echo $e->getMessage ();
			}
		}
		self::$instances ['homolog'] = $connHomolog;
		self::$instances ['dev'] = $connDev;
		return self::$instances;
	}
}