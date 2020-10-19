<?php
            
/**
 * Classe feita para manipulação do objeto Produto
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
     
     
class ProdutoDAO extends DAO {
    
    

            
            
    public function update(Produto $produto)
    {
        $id = $produto->getId();
            
            
        $sql = "UPDATE produto
                SET
                descricao = :descricao,
                valor = :valor
                WHERE produto.id = :id;";
			$descricao = $produto->getDescricao();
			$valor = $produto->getValor();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Produto $produto){
        $sql = "INSERT INTO produto(descricao, valor) VALUES (:descricao, :valor);";
		$descricao = $produto->getDescricao();
		$valor = $produto->getValor();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Produto $produto){
        $sql = "INSERT INTO produto(id, descricao, valor) VALUES (:id, :descricao, :valor);";
		$id = $produto->getId();
		$descricao = $produto->getDescricao();
		$valor = $produto->getValor();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

    }

	public function delete(Produto $produto){
		$id = $produto->getId();
		$sql = "DELETE FROM produto WHERE id = :id";
		    
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			return $stmt->execute();
			    
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}


	public function fetch() {
		$list = array ();
		$sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto LIMIT 1000";

        try {
            $stmt = $this->connection->prepare($sql);
            
		    if(!$stmt){   
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		        return $list;
		    }
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row) 
            {
		        $produto = new Produto();
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                $list [] = $produto;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(Produto $produto) {
        $lista = array();
	    $id = $produto->getId();
                
        $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
            WHERE produto.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $produto = new Produto();
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                $lista [] = $produto;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByDescricao(Produto $produto) {
        $lista = array();
	    $descricao = $produto->getDescricao();
                
        $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
            WHERE produto.descricao like :descricao";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $produto = new Produto();
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                $lista [] = $produto;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByValor(Produto $produto) {
        $lista = array();
	    $valor = $produto->getValor();
                
        $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
            WHERE produto.valor = :valor";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $produto = new Produto();
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                $lista [] = $produto;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Produto $produto) {
        
	    $id = $produto->getId();
	    $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
                WHERE produto.id = :id
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $produto;
    }
                
    public function fillByDescricao(Produto $produto) {
        
	    $descricao = $produto->getDescricao();
	    $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
                WHERE produto.descricao = :descricao
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $produto;
    }
                
    public function fillByValor(Produto $produto) {
        
	    $valor = $produto->getValor();
	    $sql = "SELECT produto.id, produto.descricao, produto.valor FROM produto
                WHERE produto.valor = :valor
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $produto->setId( $row ['id'] );
                $produto->setDescricao( $row ['descricao'] );
                $produto->setValor( $row ['valor'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $produto;
    }
}