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
//         $adicionado->setId($jsonBody['id']);

        $adicionado->setDescricao($jsonBody['descricao']);

        $adicionado->setValor($jsonBody['valor']);

        if ($this->dao->insert($adicionado)) 
        {
            echo 'Sucess.';
		} else {
			echo 'Fail';
		}
    }            
            
		
}
?>