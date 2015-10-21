<?php

class  Pai{
	
	
	protected static $item;
	
	public function __construct($item){
		self::$item = $item;
	}
	
	public function soma(){
		echo self::$item;
	}
	
}

class Filho extends Pai{
	
	public function __construct(){
		//parent::__construct($item);
		
	}
	
	public function soma(){
		echo ++self::$item;
	}
	
	
}

class  Filho1 extends Pai{
	
	public function __construct(){
		//parent::__construct($item);
	}
	
	public function soma(){
		echo self::$item += 2;
	}
	
}
echo "<br/>";
echo "<br/>";
echo "<br/>";
$pai = new Pai(1);
$filho = new Filho();
$filho ->soma();
echo "<br/>";
$pai->soma();
$filho1 = new Filho1();
echo "<br/>";
$filho1->soma();
echo "<br/>";
$pai->soma();
echo "<br/>";
$filho ->soma();



