<?php
class GerenciadorSequence {

	
	private static $criados = array();
	
	private static $queryCriado = "";
	private static $querySetado = "";
	
	
	public static function adicionaCriados($sequence) {
		static::$criados[] = $sequence;
	}
	public static function getCriados() {
		return static::$criados;
	}
	
	public static function sobreCarregaCriados($sequences){
		self::$criados = $sequences;
	}
	
	public static function adicionaQueryCriado($query) {
		self::$queryCriado = $query;
	}
	public static function getQueryCriado() {
		return self::$queryCriado;
	}
	public static function resetQueryCriado(){
		self::$queryCriado = "";
	}
	
	public static function adicionaQuerySetado($query) {
		self::$querySetado = $query;
	}
	public static function getQuerySetado() {
		return self::$querySetado;
	}
	
	public static function resetQuerySetado(){
		self::$querySetado = "";
	}
	
	public static function resetCriados() {
		self::$criados = array();
	}
}