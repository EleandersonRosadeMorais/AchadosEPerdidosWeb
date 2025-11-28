<?php
require_once "ConexaoDb.php";

class ItemPerdido
{
    private $conn;
    private $table_name = "itemPerdido";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar item perdido
    public function criar($nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem, $administrador_fk, $status = 'disponivel')
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nome, dataEncontrado, localizacaoEncontrada, localizacaoBuscar, tipo, imagem, administrador_fk, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem, $administrador_fk, $status]);
            return true;
        } catch (PDOException $e) {
            error_log("Erro ao criar item: " . $e->getMessage());
            return false;
        }
    }

    // Listar todos os itens
    public function listar()
    {
        $query = "SELECT i.*, a.nome as administrador_nome 
                 FROM " . $this->table_name . " i 
                 LEFT JOIN administrador a ON i.administrador_fk = a.id_pk 
                 ORDER BY i.dataCadastro DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $itens = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itens[] = $row;
            }
            
            return $itens;
            
        } catch (PDOException $e) {
            error_log("Erro na listagem: " . $e->getMessage());
            return array();
        }
    }

    // Buscar item por ID
    public function buscarPorId($id)
    {
        $query = "SELECT i.*, a.nome as administrador_nome 
                 FROM " . $this->table_name . " i 
                 LEFT JOIN administrador a ON i.administrador_fk = a.id_pk 
                 WHERE i.id_pk = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro na busca por ID: " . $e->getMessage());
            return false;
        }
    }

    // Atualizar item
    public function atualizar($id, $nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem = null, $status)
    {
        if ($imagem) {
            $query = "UPDATE " . $this->table_name . " 
                     SET nome = ?, dataEncontrado = ?, localizacaoEncontrada = ?, localizacaoBuscar = ?, tipo = ?, imagem = ?, status = ? 
                     WHERE id_pk = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem, $status, $id]);
        } else {
            $query = "UPDATE " . $this->table_name . " 
                     SET nome = ?, dataEncontrado = ?, localizacaoEncontrada = ?, localizacaoBuscar = ?, tipo = ?, status = ? 
                     WHERE id_pk = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $status, $id]);
        }
    }

    // Excluir item
    public function excluir($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pk = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id]);
            
        } catch (PDOException $e) {
            error_log("Erro na exclusão: " . $e->getMessage());
            return false;
        }
    }

    // Buscar itens por status
    public function buscarPorStatus($status)
    {
        $query = "SELECT i.*, a.nome as administrador_nome 
                 FROM " . $this->table_name . " i 
                 LEFT JOIN administrador a ON i.administrador_fk = a.id_pk 
                 WHERE i.status = ? 
                 ORDER BY i.dataCadastro DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$status]);
            
            $itens = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itens[] = $row;
            }
            
            return $itens;
            
        } catch (PDOException $e) {
            error_log("Erro na busca por status: " . $e->getMessage());
            return array();
        }
    }

    // Buscar itens por tipo
    public function buscarPorTipo($tipo)
    {
        $query = "SELECT i.*, a.nome as administrador_nome 
                 FROM " . $this->table_name . " i 
                 LEFT JOIN administrador a ON i.administrador_fk = a.id_pk 
                 WHERE i.tipo = ? 
                 ORDER BY i.dataCadastro DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$tipo]);
            
            $itens = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itens[] = $row;
            }
            
            return $itens;
            
        } catch (PDOException $e) {
            error_log("Erro na busca por tipo: " . $e->getMessage());
            return array();
        }
    }

    // Atualizar apenas o status do item
    public function atualizarStatus($id, $status)
    {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id_pk = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$status, $id]);
            
        } catch (PDOException $e) {
            error_log("Erro na atualização de status: " . $e->getMessage());
            return false;
        }
    }
}
?>