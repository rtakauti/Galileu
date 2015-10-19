<?php
include_once realpath(__DIR__.'/../connection/Connection.php');
include_once 'DAO.php';
class DAOImpl implements DAO {
	protected $conns;
	protected $query;
	public function __construct($dbCompany) {
		$this->conns = Connection::getInstances ( $dbCompany );
	}
	/**
	 * @param $schemaType - tipo do Ambiente DEV ou HOMOLOG
	 * @example Ex. SchemaType::HOMOLOG
	 * @return Uma array simples
	 */
	public  function query($schemaType) {
		$find = $this->conns [$schemaType]->prepare ( $this->query );
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
	/**
	 * @param $schemaType - tipo do Ambiente DEV ou HOMOLOG
	 * @example Ex. SchemaType::HOMOLOG
	 * @return Uma array com profundidade de nivel maior que 1 Associativo
	 */
	public function queryAllAssoc($schemaType) {
		$find = $this->conns [$schemaType]->prepare ( $this->query );
		$find->execute ();
		return $find->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	
	

	
	
	
}