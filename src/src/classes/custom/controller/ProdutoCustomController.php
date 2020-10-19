<?php
            
/**
 * Customize o controller do objeto Produto aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class ProdutoCustomController  extends ProdutoController {
    

	public function __construct(){
		$this->dao = new ProdutoCustomDAO();
		$this->view = new ProdutoCustomView();
	}


	        
}
?>