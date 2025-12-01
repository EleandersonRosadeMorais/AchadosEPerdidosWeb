<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS achados_perdidos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->exec("USE achados_perdidos");

    $conn->exec("CREATE TABLE IF NOT EXISTS administrador (
        id_pk INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        cpf VARCHAR(14) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS itemPerdido (
        id_pk INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        dataEncontrado DATE NOT NULL,
        localizacaoEncontrada VARCHAR(200) NOT NULL,
        localizacaoBuscar VARCHAR(200) NOT NULL,
        tipo VARCHAR(50),
        imagem VARCHAR(255),
        administrador_fk INT,
        status ENUM('disponivel', 'devolvido', 'arquivado') DEFAULT 'disponivel',
        dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (administrador_fk) REFERENCES administrador(id_pk)
    )");

    $senha_hash1 = password_hash('senha123', PASSWORD_BCRYPT);
    $senha_hash2 = password_hash('senha456', PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT IGNORE INTO administrador (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
    $stmt->execute(['João Silva', '123.456.789-00', 'joao.silva@email.com', $senha_hash1]);
    $stmt->execute(['Maria Santos', '987.654.321-00', 'maria.santos@email.com', $senha_hash2]);

    $stmt2 = $conn->prepare("INSERT IGNORE INTO itemPerdido (nome, dataEncontrado, localizacaoEncontrada, localizacaoBuscar, tipo, imagem, administrador_fk, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->execute(['Celular Samsung', '2024-01-15', 'Bloco A - Sala 101', 'Secretaria - Bloco Central', 'Eletrônico', 'garrafa.jpg', 1, 'disponivel']);
    $stmt2->execute(['Mochila Preta', '2024-01-10', 'Biblioteca - Setor de Estudos', 'Portaria 1', 'Acessório', 'garrafa.jpg', 2, 'disponivel']);
    $stmt2->execute(['Garrafa Térmica Azul', '2024-01-12', 'Refeitório - Mesa 5', 'Secretaria - Bloco Central', 'Utensílio', 'garrafa.jpg', 1, 'devolvido']);

    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Configuração Concluída</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .container {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                text-align: center;
                max-width: 600px;
                width: 90%;
            }
            .success-icon {
                font-size: 80px;
                color: #28a745;
                margin-bottom: 20px;
            }
            h1 {
                color: #333;
                margin-bottom: 20px;
            }
            .info-box {
                background: #f8f9fa;
                border-left: 4px solid #02416D;
                padding: 15px;
                margin: 15px 0;
                text-align: left;
            }
            .credentials {
                background: #e8f5e8;
                border: 1px solid #28a745;
                border-radius: 8px;
                padding: 15px;
                margin: 20px 0;
            }
            .btn {
                display: inline-block;
                background: #02416D;
                color: white;
                padding: 12px 30px;
                text-decoration: none;
                border-radius: 8px;
                margin: 10px;
                transition: background 0.3s;
            }
            .btn:hover {
                background: #013354;
            }
            .warning {
                color: #dc3545;
                font-weight: bold;
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #dc3545;
                border-radius: 5px;
                background: #f8d7da;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="success-icon">✅</div>
            <h1>Configuração Concluída!</h1>
            
            <div class="info-box">
                <strong>📊 Banco de dados criado com sucesso!</strong><br>
                Tabelas: administrador, itemPerdido
            </div>
            
            <div class="credentials">
                <strong>👑 Administradores Criados:</strong><br><br>
                <strong>João Silva:</strong><br>
                📧 Email: joao.silva@email.com<br>
                🔑 Senha: senha123<br><br>
                
                <strong>Maria Santos:</strong><br>
                📧 Email: maria.santos@email.com<br>
                🔑 Senha: senha456
            </div>
            
            <div class="info-box">
                <strong>📦 Dados de Exemplo:</strong><br>
                3 itens cadastrados para teste
            </div>
            
            <div>
                <a href="../index.html" class="btn">🏠 Página Inicial</a>
                <a href="index.php" class="btn">🚀 Acessar Sistema</a>
                <a href="login.php" class="btn">🔐 Fazer Login</a>
            </div>
            
            <div class="warning">
                ⚠️ IMPORTANTE: Exclua este arquivo (setup_simples.php) por segurança!
            </div>
        </div>
    </body>
    </html>
    ';

} catch (PDOException $e) {
    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erro na Configuração</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                color: white;
            }
            .container {
                background: rgba(255,255,255,0.95);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                text-align: center;
                max-width: 500px;
                width: 90%;
                color: #333;
            }
            .error-icon {
                font-size: 80px;
                color: #dc3545;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="error-icon">❌</div>
            <h1>Erro na Configuração</h1>
            <p><strong>Erro:</strong> ' . $e->getMessage() . '</p>
            <p>Verifique se o MySQL está rodando e as credenciais estão corretas.</p>
            <a href="../index.php" class="btn">🏠 Voltar para Home</a>
        </div>
    </body>
    </html>
    ';
}
?>