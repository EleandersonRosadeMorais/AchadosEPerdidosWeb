<?php
session_start();
require_once('db/conexao_db.php');
require_once('db/tab_administrador.php');

$mensagem_erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);
        
        $query = "SELECT id_pk, nome, senha FROM administrador WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $admin['id_pk'];
            $_SESSION['admin_nome'] = $admin['nome'];
            header('Location: adm/gerenciar_itens.php');
            exit();
        } else {
            $mensagem_erro = "Email ou senha incorretos!";
        }
        
    } catch (Exception $e) {
        $mensagem_erro = "Erro no sistema: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <form method="POST">
            <h1>Fazer login</h1>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <br><br>

            <input type="submit" name="login" value="Login">
        </form>

        <div class="mensagem">
            <?php if (!empty($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
        </div>
    </div>
</body>
</html>