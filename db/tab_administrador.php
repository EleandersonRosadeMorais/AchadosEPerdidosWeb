<?php
require_once "ConexaoDb.php";

class Usuario
{
    private $conn;
    private $table_name = "administrador";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar($nome,$cpf, $email, $senha,)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, cpf, email, senha) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);

        try {
            $stmt->execute([$nome,$cpf,  $email, $hashed_password, ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $senha) {
        // Verifica se a conexão existe
        if (!$this->conn) {
            throw new Exception("Conexão com banco não estabelecida");
        }
    
        $query = "SELECT id_usuario, nome, senha FROM Usuario WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Retorna os dados do usuário (sem a senha)
                return [
                    'id' => $usuario['id_usuario'], 
                    'nome' => $usuario['nome'],
                    'email' => $email
                ];
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Erro no login: " . $e->getMessage());
        }
    }

    public function buscarPorId($id)
    {
        $query = "SELECT id, nome, cpf, email FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $cpf, $email, $senha = null)
    {
        if ($senha) {
            $query = "UPDATE " . $this->table_name . " SET nome = ?,SET cpf = ?, email = ?, senha = ? WHERE id = ?";
            $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $cpf, $email, $hashed_password, $id]);
        } else {
            $query = "UPDATE " . $this->table_name . " SET nome = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $email, $id]);
        }
    }

    public function excluir($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>