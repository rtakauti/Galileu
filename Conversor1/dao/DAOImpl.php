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
		$query = $this->query;
		$find = $this->conns [$schemaType]->prepare ( $query );
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
	 * @return Uma array com profundidade de nivel maior que 1 Associativo
	 */
	public function queryAllAssoc($schemaType) {
		$query = $this->query;
		$find = $this->conns [$schemaType]->prepare ( $query );
		$find->execute ();
		$resultado = array();
		while ($rst = $find->fetch ( PDO::FETCH_ASSOC )){
			$resultado[]=$rst;
		}
		return $resultado;
	}
	
	
	

	
	
	
}