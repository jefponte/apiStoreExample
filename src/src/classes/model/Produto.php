<?php
            
/**
 * Classe feita para manipulação do objeto Produto
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class Produto {
	private $id;
	private $descricao;
	private $valor;
    public function __construct(){

    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
		    
	public function getDescricao() {
		return $this->descricao;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
		    
	public function getValor() {
		return $this->valor;
	}
	public function __toString(){
	    return $this->id.' - '.$this->descricao.' - '.$this->valor;
	}
                

}
?>