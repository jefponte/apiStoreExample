<?php
            
/**
 * Classe feita para manipulação do objeto Produto
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class ProdutoController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new ProdutoDAO();
		$this->view = new ProdutoView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new Produto();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_produto'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Produto
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Produto
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=produto">';
    }



	public function list() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_produto'])){
            $this->view->showInsertForm();
		    return;
		}
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['valor'] ))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing. 
                </div>

                ';
			return;
		}
            
		$produto = new Produto ();
		$produto->setDescricao ( $_POST ['descricao'] );
		$produto->setValor ( $_POST ['valor'] );
            
		if ($this->dao->insert ( $produto ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir Produto
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Produto
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=produto">';
	}



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_produto'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['valor'] ))) {
			echo ':incompleto';
			return;
		}
            
		$produto = new Produto ();
		$produto->setDescricao ( $_POST ['descricao'] );
		$produto->setValor ( $_POST ['valor'] );
            
		if ($this->dao->insert ( $produto ))
        {
			$id = $this->dao->getConnection()->lastInsertId();
            echo ':sucesso:'.$id;
            
		} else {
			 echo ':falha';
		}
	}
            
            

            
    public function edit(){
	    if(!isset($_GET['edit'])){
	        return;
	    }
        $selected = new Produto();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_produto'])){
            $this->view->showEditForm($selected);
            return;
        }
            
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['valor'] ))) {
			echo "Incompleto";
			return;
		}

		$selected->setDescricao ( $_POST ['descricao'] );
		$selected->setValor ( $_POST ['valor'] );
            
		if ($this->dao->update ($selected ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso 
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha 
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=produto">';
            
    }
        
    
    public function main(){
        
        if (isset($_GET['select'])){
            echo '<div class="row justify-content-center">';
                $this->select();
            echo '</div>';
            return;
        }
        echo '
		<div class="row justify-content-center">';
        echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';
        
        if(isset($_GET['edit'])){
            $this->edit();
        }else if(isset($_GET['delete'])){
            $this->delete();
	    }else{
            $this->add();
        }
        $this->list();
        
        echo '</div>';
        echo '</div>';
            
    }
    public function mainAjax(){

        $this->addAjax();
        
            
    }
    public function mainREST($iniApiFile = API_INI)
    {
        
        $config = parse_ini_file ( $iniApiFile );
        $user = $config ['user'];
        $password = $config ['password'];
        
        if(!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\" ");
            header("HTTP/1.0 401 Unauthorized");
            echo '{"erro":[{"status":"error","message":"Authentication failed"}]}';
            return;
        }
        if($_SERVER['PHP_AUTH_USER'] == $user && ($_SERVER['PHP_AUTH_PW'] == $password)){
            header('Content-type: application/json');
            
            $this->restGET();
            $this->restPOST();
//             $this->restPUT();
            $this->resDELETE();
        }else{
            header("WWW-Authenticate: Basic realm=\"Private Area\" ");
            header("HTTP/1.0 401 Unauthorized");
            echo '{"erro":[{"status":"error","message":"Authentication failed"}]}';
        }

    }

    public function select(){
	    if(!isset($_GET['select'])){
	        return;
	    }
        $selected = new Produto();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
	public function restGET()
    {

        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }

        if(!isset($_REQUEST['api'])){
            return;
        }
        $url = explode("/", $_REQUEST['api']);
        if (count($url) == 0 || $url[0] == "") {
            return;
        }
        if ($url[1] != 'produto') {
            return;
        }

        if(isset($url[2])){
            $parametro = $url[2];
            $id = intval($parametro);
            $selected = new Produto();
            $selected->setId($id);
            $selected = $this->dao->preenchePorId($selected);
            if ($selected == null) {
                echo "{}";
                return;
            }

            $selected = array(
					'id' => $selected->getId (), 
					'descricao' => $selected->getDescricao (), 
					'valor' => $selected->getValor ()
            
            
			);
            echo json_encode($selected);
            return;
        }        
        $list = $this->dao->fetch();
        $listagem = array();
        foreach ( $list as $linha ) {
			$listagem ['list'] [] = array (
					'id' => $linha->getId (), 
					'descricao' => $linha->getDescricao (), 
					'valor' => $linha->getValor ()
            
            
			);
		}
		echo json_encode ( $listagem );
    
		
		
		
		
	}

    public function resDELETE()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return;
        }
        $path = explode('/', $_GET['api']);
        $parametro = "";
        if (count($path) < 2) {
            return;
        }
        $parametro = $path[1];
        if ($parametro == "") {
            return;
        }
    
        $id = intval($parametro);
        $selected = new Produto();
        $selected->setId($id);
        $selected = $this->dao->pesquisaPorId($selected);
        if ($selected == null) {
            echo "{}";
            return;
        }

        if($this->dao->excluir($selected))
        {
            echo "{}";
            return;
        }
        
        echo "Erro.";
        
    }
    public function restPUT()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return;
        }

        if (! array_key_exists('api', $_GET)) {
            return;
        }
        $path = explode('/', $_GET['api']);
        if (count($path) == 0 || $path[0] == "") {
            echo 'Error. Path missing.';
            return;
        }
        
        $param1 = "";
        if (count($path) > 1) {
            $parametro = $path[1];
        }

        if ($path[0] != 'info') {
            return;
        }

        if ($param1 == "") {
            echo 'error';
            return;
        }

        $id = intval($parametro);
        $selected = new Produto();
        $selected->setId($id);
        $selected = $this->dao->pesquisaPorId($selected);

        if ($selected == null) {
            return;
        }

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        
        
        if (isset($jsonBody['id'])) {
            $selected->setId($jsonBody['id']);
        }
                    

        if (isset($jsonBody['descricao'])) {
            $selected->setDescricao($jsonBody['descricao']);
        }
                    

        if (isset($jsonBody['valor'])) {
            $selected->setValor($jsonBody['valor']);
        }
                    

        if ($this->dao->update($selected)) 
                {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso 
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha 
</div>

';
		}
    }

    public function restPOST()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
        if (! array_key_exists('api', $_GET)) {
            echo 'Error. Path missing.';
            return;
        }
        
        $path = explode('/', $_GET['api']);

        if (count($path) == 0 || $path[0] == "") {
            echo 'Error. Path missing.';
            return;
        }

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);

        if (! ( isset ( $jsonBody ['descricao'] ) && isset ( $jsonBody ['valor'] ))) {
			echo "Incompleto";
			return;
		}

        $adicionado = new Produto();
        $adicionado->setId($jsonBody['id']);

        $adicionado->setDescricao($jsonBody['descricao']);

        $adicionado->setValor($jsonBody['valor']);

        if ($this->dao->inserir($adicionado)) 
                {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso 
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha 
</div>

';
		}
    }            
            
		
}
?>