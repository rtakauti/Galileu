<?php



class GerenciadorSequence{

	static public $criado = array();

	static  public $setado = array();


}

class Teste{
	
	public function adicionar($valor){
		GerenciadorSequence::$criado[] = $valor;
	}
	
}

$teste = new Teste();
$teste->adicionar("dfs");
$teste->adicionar("sfdsf");
echo "<pre>";
print_r( GerenciadorSequence::$criado);
echo "</pre>";
$teste->adicionar("dfs");
$teste->adicionar("sfdsf");
echo "<pre>";
print_r( GerenciadorSequence::$criado);
echo "</pre>";
GerenciadorSequence::$criado = array_unique(GerenciadorSequence::$criado);
echo "<pre>";
print_r( GerenciadorSequence::$criado);
echo "</pre>";
