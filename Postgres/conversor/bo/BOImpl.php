<?php
include_once 'BO.php';
class BOImpl implements BO {
	
	protected $dao;
	
	public function  __construct($dbCompany){
		$this->dao = new DAOImpl($dbCompany);
	}
	
	/**
	 * 
	 * @return Array simples de Homolog
	 */
	public function arrayHomolog() {
		return $this->dao->query ( SchemaType::HOMOLOG );
	}
	/**
	 * @return Array simples de Dev
	 */
	public function arrayDev() {
		return $this->dao->query ( SchemaType::DEV );
	}
	/**
	 * @return Array com profundidade maior que 1 de HOMOLOG
	 */
	public function arrayHomolgAll(){
		return $this->dao->queryAllAssoc(SchemaType::HOMOLOG);
	}
	/**
	 * @return Array com profundidade maior que 1 de DEV
	 */
	public function arrayDevAll() {
		return $this->dao->queryAllAssoc( SchemaType::DEV );
	}
	
	/**
	 * @return Um array simples diff homolog dev
	 */
	public function diff_homolog_devQuery() {
		$homolog = $this->dao->query ( SchemaType::HOMOLOG );
		$dev = $this->dao->query ( SchemaType::DEV );
		return array_diff ( $homolog, $dev );
	}
	/**
	 * @return Um array intersect homolog dev
	 */
	public function intersect_homolog_devQuery() {
		$homolog = $this->dao->query ( SchemaType::HOMOLOG );
		$dev = $this->dao->query ( SchemaType::DEV );
		return array_intersect ( $homolog, $dev );
	}
	/**
	 * @return Um array diff dev homolog
	 */
	public function diff_dev_homologQuery() {
		$homolog = $this->dao->query ( SchemaType::HOMOLOG );
		$dev = $this->dao->query ( SchemaType::DEV );
		return array_diff ( $dev, $homolog );
	}
	
	
}