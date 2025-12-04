<?php
class Database
{
    private $host = "localhost";
    private $db_name = "achados_perdidos";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            // SOLUÇÃO PARA SERVIDOR (pode ser diferente do localhost)
            // Opção 1: Tentar com utf8mb4
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Comandos CRÍTICOS para servidor
            $this->conn->exec("SET NAMES 'utf8mb4'");
            $this->conn->exec("SET CHARACTER SET utf8mb4");
            $this->conn->exec("SET character_set_connection = utf8mb4");
            $this->conn->exec("SET character_set_client = utf8mb4");
            $this->conn->exec("SET character_set_results = utf8mb4");
            
        } catch (PDOException $exception) {
            // Se utf8mb4 falhar, tentar utf8
            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("SET NAMES 'utf8'");
            } catch (PDOException $e) {
                // Se tudo falhar, sem charset (como provavelmente está funcionando no localhost)
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }
        return $this->conn;
    }
}