<?php
session_start();
require_once('db/conexao_db.php');
require_once('db/tab_administrador.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);
        
        if ($usuario->registrar($nome, $cpf, $email, $senha)) {
            $mensagem_sucesso = "Administrador cadastrado com sucesso!";
        } else {
            $mensagem_erro = "Erro ao cadastrar administrador. Email ou CPF já existem.";
        }
        
    } catch (Exception $e) {
        $mensagem_erro = "Erro no sistema: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box2">
        <form method="POST">
            <h1>Registrar administrador</h1>

            <?php if (isset($mensagem_sucesso)): ?>
                <div style="color: green; margin-bottom: 15px;"><?php echo $mensagem_sucesso; ?></div>
            <?php endif; ?>
            
            <?php if (isset($mensagem_erro)): ?>
                <div style="color: red; margin-bottom: 15px;"><?php echo $mensagem_erro; ?></div>
            <?php endif; ?>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($nome ?? ''); ?>">
            
            <br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($email ?? ''); ?>">

            <br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <br><br>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" placeholder="000.000.000-00" required value="<?= htmlspecialchars($cpf ?? ''); ?>">

            <br><br>

            <input type="submit" value="Registrar">

            <a href="/achadosEperdidosWeb/adm/gerenciar_itens.php" class="btn-voltar2">Retornar</a>
        </form>
    </div>
</body>
</html>