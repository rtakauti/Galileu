<?php

class  Pai{
	
	
	public static $item;
	
	public function __construct($item){
		self::$item = $item;
	}
	
	public static function getItem(){
		echo self::$item;
	}
	
	
	
}

class Filho {
	
	private $pai;
	
	
	public function __construct(){
		$this->pai = new Pai(1);
	}
	
	public static function soma(){
		$pai = new Pai(1);
		echo ++$pai::$item;
	}
	
	
}

class  Filho1 extends Pai{
	
	public function __construct(){
		//parent::__construct($item);
	}
	
	public static function soma(){
		echo self::$item += 2;
	}
	
}
echo "<br/>";
echo "<br/>";
echo "<br/>";
$pai = new Pai(1);
$pai::getItem();
echo "<br/>";
$filho = new Filho();
$filho::soma();
echo "<br/>";
$pai::getItem();
echo "<br/>";
$filho1 = new Filho1();
$filho1::soma();
echo "<br/>";
$pai::getItem();

