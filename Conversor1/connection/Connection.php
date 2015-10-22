<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
//ini_set("max_execution_time", 3000);
class Connection {
	private static $instances;
	private function __construct() {
	}
	public static function getInstances( $dbCompany) {
		if (! isset ( self::$conns )) {
			try {
				$config = parse_ini_file ( __DIR__."/config/config.ini", true );
				$host = $config ['connection'] ['host'];
				$user = $config ['connection'] ['user'];
				$pass = $config ['connection'] ['pass'];
				$schemaHomolog = $config [$dbCompany] ['homolog'];
				$schemaDev = $config [$dbCompany] ['dev'];
				
				$connHomolog = new PDO ( "pgsql:dbname={$schemaHomolog};host={$host}", $user, $pass );
				$connHomolog->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				
				$connDev = new PDO ( "pgsql:dbname={$schemaDev};host={$host}", $user, $pass );
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