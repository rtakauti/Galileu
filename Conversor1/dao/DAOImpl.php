<?php
include_once realpath(__DIR__.'/../connection/Connection.php');
include_once 'IDAO.php';
class DAOImpl implements IDAO {
	
	protected $conns;
	protected $query;
	
	public function __construct() {
		$this->conns = Connection::getInstances (  );
	}
	
	/**
	 * @param $schemaType - tipo do Ambiente DEV ou HOMOLOG
	 * @example Ex. SchemaType::HOMOLOG
	 * @return Uma array simples
	 */
	public  function query($schemaType) {
		$find = $this->conns [$schemaType]->prepare ( $this->query );
		$find->execute ();
		$resultadoArray = array ();
		while ($rst =  $find->fetch ( PDO::FETCH_NUM )) {
			$resultadoArray[] = $rst[0];
		}
		return $resultadoArray;
	}
	/**
	 * @param $schemaType - tipo do Ambiente DEV ou HOMOLOG
	 * @example Ex. SchemaType::HOMOLOG
	 * @return Uma array simples
	 */
	public  function queryAssoc($schemaType) {
		$find = $this->conns [$schemaType]->prepare ( $this->query );
		$find->execute ();
		//$resultado = $find->fetchAll ( PDO::FETCH_ASSOC );
		$resultado = array();
		while ($rst = $find->fetch ( PDO::FETCH_ASSOC )){
			$resultado[]=$rst;
		}
		$resultadoArray = array ();
		foreach ( $resultado as $values ) {
			foreach ( $values as $key => $value ) {
				$resultadoArray [$key] = $value;
			}
		}
		return $resultadoArray;
	}
	/**
	 * @param $schemaType - tipo do Ambiente DEV ou HOMOLOG
	 * @example Ex. SchemaType::HOMOLOG
	 * @return Uma array com profundidade de nivel maior que 1 Associativo
	 */
	public function queryAllAssoc($schemaType) {
		$find = $this->conns [$schemaType]->prepare ( $this->query );
		$find->execute ();
		$resultado = array();
		while ($rst = $find->fetch ( PDO::FETCH_ASSOC )){
			$resultado[]=$rst;
		}
		return $resultado;
	}
	
	
	

	
	
	
}