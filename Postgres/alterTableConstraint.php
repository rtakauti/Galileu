<?php
const CONSTRAINT_NAME = 0;
const CONSTRAINT_TYPE = 1;
const COLUMN_NAME = 2;
const MATCH_OPTION = 3;
const UPDATE_RULE = 4;
const DELETE_RULE = 5;
const ORDINAL_POSITION = 6;
const CONSRC = 7;
const FOREIGN_TABLE_NAME = 8;
const FOREIGN_COLUMN_NAME = 9;

$dbnameDev = "rubens_teste";
$dbnameHomolog = "rubens_test";
$file = $dbnameHomolog . "_scriptConstraints.sql";

$host = "gdev.galileulog.com.br";
$dbuser = "postgres";
$dbpass = "g@l1l3u2012";

$tableColumnAttrib = array (
		'constraint_name',
		'constraint_type',
		'column_name',
		'match_option',
		'update_rule',
		'delete_rule',
		'ordinal_position',
		'consrc',
		'foreign_table_name',
		'foreign_column_name' 
);

$schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public' and table_name = 'tabela3'";
// $schemaQuery = "select distinct table_name from information_schema.columns where table_schema = 'public'";
try {
	$dbTablesDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbTablesHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
	
	$dbDev = new PDO ( "pgsql:dbname=$dbnameDev;host=$host", $dbuser, $dbpass );
	$dbHomolog = new PDO ( "pgsql:dbname=$dbnameHomolog;host=$host", $dbuser, $dbpass );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}

$findTableDev = $dbTablesDev->prepare ( $schemaQuery );
$findTableDev->execute ();
$resultadoTableDev = $findTableDev->fetchAll ( PDO::FETCH_NUM );

foreach ( $resultadoTableDev as $key => $tabela ) {
	$table = $tabela [0];
	$constraintQuery = "	select ";
	$constraintQuery .= " tc.constraint_name,  ";
	$constraintQuery .= " tc.constraint_type,  ";
	$constraintQuery .= " kcu.column_name,  ";
	$constraintQuery .= " rc.match_option,  ";
	$constraintQuery .= " rc.update_rule,  ";
	$constraintQuery .= " rc.delete_rule,  ";
	$constraintQuery .= " kcu.ordinal_position, ";
	$constraintQuery .= " c.consrc, ";
	$constraintQuery .= " ccu.table_name as foreign_table_name, ";
	$constraintQuery .= " ccu.column_name as foreign_column_name ";
	$constraintQuery .= " from information_schema.table_constraints tc ";
	$constraintQuery .= " left join information_schema.key_column_usage kcu ";
	$constraintQuery .= " on tc.constraint_catalog = kcu.constraint_catalog ";
	$constraintQuery .= " and tc.constraint_schema = kcu.constraint_schema ";
	$constraintQuery .= " and tc.constraint_name = kcu.constraint_name ";
	$constraintQuery .= " left join information_schema.referential_constraints rc ";
	$constraintQuery .= " on tc.constraint_catalog = rc.constraint_catalog ";
	$constraintQuery .= " and tc.constraint_schema = rc.constraint_schema ";
	$constraintQuery .= " and tc.constraint_name = rc.constraint_name ";
	$constraintQuery .= " left join information_schema.constraint_column_usage ccu ";
	$constraintQuery .= " on rc.unique_constraint_catalog = ccu.constraint_catalog ";
	$constraintQuery .= " and rc.unique_constraint_schema = ccu.constraint_schema ";
	$constraintQuery .= " and rc.unique_constraint_name = ccu.constraint_name ";
	$constraintQuery .= " left join pg_constraint c ";
	$constraintQuery .= " on tc.constraint_name = c.conname ";
	$constraintQuery .= " where tc.table_name = 'tabela3' ";
	$constraintQuery .= " and upper(tc.constraint_name) not like '%NOT_NULL%'";
	$constraintQuery .= " order by 1";
	
	$findDev = $dbDev->prepare ( $constraintQuery );
	$findDev->execute ();
	$resultadoDev = $findDev->fetchAll ( PDO::FETCH_NUM );
	
	$findHomolog = $dbHomolog->prepare ( $constraintQuery );
	$findHomolog->execute ();
	$resultadoHomolog = $findHomolog->fetchAll ( PDO::FETCH_NUM );
	
	// Cria um arquivo com um comentario contendo a tabela analisada em questão
	
	  $f = fopen ( $file, "a+", 0 );
	  $tabelaScript = "\n\n\n-------------------------- TABELA: $table --------------------------\n\n\n";
	  fwrite ( $f, $tabelaScript, strlen ( $tabelaScript ) );
	  fclose ( $f );
	
	
	  /*
	   *
	   * Constroi um array de CONSTRAINTS de Dev
	   *
	   */
	  $chaves = array ();
	  $tipoChaves = array ();
	  for($i = 0; $i < count ( $resultadoDev ); $i ++) {
	  	$chaves [] = $resultadoDev [$i] [0];
	  }
	  //soma valores de key iguais
	  $qtChaves = array_count_values ( $chaves );
	  
	  // formar as constraints da tabela secundaria
	  $j = 0;
	  $virgula = - 1;
	  $scriptConstraint = "";
	  $scriptDropConstraint = "";
	  $constraintsDev = array();
	  $constraintsDropDev = array();
	  $referenceFK = "";
	  foreach ( $qtChaves as $key => $value ) {
	  	$nomeConstraint = $key;
	  	$scriptDropConstraint .= "\nALTER TABLE $table DROP CONSTRAINT " . $nomeConstraint.";";
	  	$scriptConstraint .= "\nALTER TABLE $table\nADD CONSTRAINT " . $nomeConstraint;
	  	if ($resultadoDev [$j] [1] == "CHECK") {
	  		$scriptConstraint .= "\n" . $resultadoDev [$j] [1] . " " . $resultadoDev [$j] [7] . ";";
	  		$j ++;
	  		$virgula ++;
	  	} elseif ($resultadoDev [$j] [1] == "FOREIGN KEY") {
	  		$referenceFK .= "\nREFERENCES " . $resultadoDev [$j] [8] . " (" . $resultadoDev [$j] [9] . ")";
	  		if ($resultadoDev [$j] [4] != "NO ACTION") {
	  			$referenceFK .= "\nON UPDATE " . $resultadoDev [$j] [4];
	  		}
	  		if ($resultadoDev [$j] [5] != "NO ACTION") {
	  			$referenceFK .= "\nON DELETE " . $resultadoDev [$j] [5];
	  		}
	  		if ($resultadoDev [$j] [3] == "NONE") {
	  			$referenceFK .= "\nMATCH SIMPLE";
	  		}else{
	  			$referenceFK .= "\nMATCH " . $resultadoDev [$j] [3];
	  		}
	  		$referenceFK .= ";";
	  		$j ++;
	  		$virgula ++;
	  	} else {
	  		$scriptConstraint .= "\n" . $resultadoDev [$j] [1] . " (";
	  		$virgula += $value;
	  		for($i = 0; $i < $value; $i ++) {
	  			if ($virgula == $j) {
	  				$scriptConstraint .= $resultadoDev [$j] [2];
	  			} else {
	  				$scriptConstraint .= $resultadoDev [$j] [2] . ", ";
	  			}
	  			$j ++;
	  		}
	  		$scriptConstraint .= ");";
	  	} // fecha if verifica se igual a CHECK
	  	$scriptConstraint .= $referenceFK . "\n";
	  	$referenceFK = null;
	  } // fecha foreach
	  echo nl2br($scriptDropConstraint);
	  echo nl2br ( $scriptConstraint );
	  $constraintsDev = explode("\n\n", $scriptConstraint);
	  $constraintsDropDev = explode("\n", substr($scriptDropConstraint, 1));
	  echo "<pre>";
	  print_r($constraintsDev);
	  print_r($constraintsDropDev);
	  echo "</pre>";
	  
	  
	  /*
	   * 
	   * Constroi um array de CONSTRAINTS de Homolog
	   * 
	   */
	$chaves = array ();
	$tipoChaves = array ();
	for($i = 0; $i < count ( $resultadoHomolog ); $i ++) {
		$chaves [] = $resultadoHomolog [$i] [0];
	}
	//soma valores de key iguais
	$qtChaves = array_count_values ( $chaves );
	
	// formar as constraints da tabela secundaria
	$j = 0;
	$virgula = - 1;
	$scriptConstraint = "";
	$scriptDropConstraint = "";
	$constraintsHomolog = array();
	$referenceFK = "";
	$constraintsDropHomolog = array();
	foreach ( $qtChaves as $key => $value ) {
		$nomeConstraint = $key;
		$scriptDropConstraint .= "\nALTER TABLE $table DROP CONSTRAINT " . $nomeConstraint.";";
		$scriptConstraint .= "\nALTER TABLE $table\nADD CONSTRAINT " . $nomeConstraint;
		if ($resultadoHomolog [$j] [1] == "CHECK") {
			$scriptConstraint .= "\n" . $resultadoHomolog [$j] [1] . " " . $resultadoHomolog [$j] [7] . ";";
			$j ++;
			$virgula ++;
		} elseif ($resultadoHomolog [$j] [1] == "FOREIGN KEY") {
			$referenceFK .= "\nREFERENCES " . $resultadoHomolog [$j] [8] . " (" . $resultadoHomolog [$j] [9] . ")";
			if ($resultadoHomolog [$j] [4] != "NO ACTION") {
				$referenceFK .= "\nON UPDATE " . $resultadoHomolog [$j] [4];
			}
			if ($resultadoHomolog [$j] [5] != "NO ACTION") {
				$referenceFK .= "\nON DELETE " . $resultadoHomolog [$j] [5];
			}
			if ($resultadoHomolog [$j] [3] == "NONE") {
				$referenceFK .= "\nMATCH SIMPLE";
			}else{
				$referenceFK .= "\nMATCH " . $resultadoHomolog [$j] [3];
			}
			$referenceFK .= ";";
			$j ++;
			$virgula ++;
		} else {
			$scriptConstraint .= "\n" . $resultadoHomolog [$j] [1] . " (";
			$virgula += $value;
			for($i = 0; $i < $value; $i ++) {
				if ($virgula == $j) {
					$scriptConstraint .= $resultadoHomolog [$j] [2];
				} else {
					$scriptConstraint .= $resultadoHomolog [$j] [2] . ", ";
				}
				$j ++;
			}
			$scriptConstraint .= ");";
		} // fecha if verifica se igual a CHECK
		$scriptConstraint .= $referenceFK . "\n";
		$referenceFK = null;
	} // fecha foreach
	echo nl2br($scriptDropConstraint);
	echo nl2br ( $scriptConstraint );
	$constraintsHomolog = explode("\n\n", $scriptConstraint);
	$constraintsDropHomolog = explode("\n", substr($scriptDropConstraint, 1));
	echo "<pre>";
	print_r($constraintsHomolog);
	print_r($constraintsDropHomolog);
	echo "</pre>";
}// fecha foreach
echo "<pre>";
print_r(array_diff($constraintsDropHomolog, $constraintsDropDev));
echo "</pre>";
$compararConstraint = array_diff($constraintsDropHomolog, $constraintsDropDev);
foreach ($compararConstraint as $value){
	echo $value;
}

