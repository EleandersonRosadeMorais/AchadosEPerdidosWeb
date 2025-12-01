<?php
require_once "conexao_db.php";

class Usuario
{
    private $conn;
    private $table_name = "administrador";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar($nome, $cpf, $email, $senha)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, cpf, email, senha) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);

        try {
            $stmt->execute([$nome, $cpf, $email, $hashed_password]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $senha) {
        if (!$this->conn) {
            throw new Exception("Conexão com banco não estabelecida");
        }

        $query = "SELECT id_pk, nome, senha FROM administrador WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                return [
                    'id' => $usuario['id_pk'], 
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
        $query = "SELECT id_pk, nome, cpf, email FROM " . $this->table_name . " WHERE id_pk = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $cpf, $email, $senha = null)
    {
        if ($senha) {
            $query = "UPDATE " . $this->table_name . " SET nome = ?, cpf = ?, email = ?, senha = ? WHERE id_pk = ?";
            $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $cpf, $email, $hashed_password, $id]);
        } else {
            $query = "UPDATE " . $this->table_name . " SET nome = ?, cpf = ?, email = ? WHERE id_pk = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nome, $cpf, $email, $id]);
        }
    }

    public function excluir($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pk = ?";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>