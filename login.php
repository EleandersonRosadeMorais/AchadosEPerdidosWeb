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
        
        $query = "SELECT id_pk, nome, senha FROM administrador WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $admin['id_pk'];
            $_SESSION['admin_nome'] = $admin['nome'];
            
            // Redireciona para a página inicial
            header('Location: index.php');
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Achados e Perdidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        /* Estilos específicos para login */
        .login-container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(2, 65, 109, 0.15);
            border-top: 5px solid #02416D;
            position: relative;
            text-align: center;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #02416D 0%, #CDD071 100%);
        }

        .login-icon {
            font-size: 4rem;
            color: #02416D;
            margin-bottom: 20px;
            display: block;
        }

        .login-title {
            color: #02416D;
            font-size: 2rem;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #CDD071;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .login-form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #02416D;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .form-group label i {
            width: 20px;
            color: #CDD071;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #02416D;
            background: white;
            box-shadow: 0 0 0 3px rgba(2, 65, 109, 0.1);
        }

        .login-button {
            background: #02416D;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 20px;
        }

        .login-button:hover {
            background: #0268A6;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(2, 65, 109, 0.3);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .error-message i {
            font-size: 1.2rem;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }

        .login-footer {
            margin-top: 30px;
            color: #666;
            font-size: 0.9rem;
        }

        .login-note {
            background: rgba(205, 208, 113, 0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #CDD071;
            margin: 20px 0;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 40px 20px;
                padding: 40px 25px;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
<?php 
// Não incluir o header padrão na página de login
// include('templates/cabecalho.php'); 
?>
<!-- Header simplificado para login -->
<header class="main-header">
    <div class="header-content">
        <a href="index.php" class="logo-link">
            <i class="fas fa-box-open"></i>
            Achados e Perdidos
        </a>
        <nav>
            <ul class="nav-list">
                <li><a href="index.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Voltar ao Site
                </a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="login-container">
    <i class="fas fa-user-shield login-icon"></i>
    
    <h1 class="login-title">
        <i class="fas fa-lock"></i> Área Administrativa
    </h1>

    <div class="login-note">
        <i class="fas fa-info-circle"></i>
        Acesso restrito para administradores do sistema
    </div>

    <?php if (!empty($mensagem_erro)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo htmlspecialchars($mensagem_erro); ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" class="login-form">
        <div class="form-group">
            <label for="email">
                <i class="fas fa-envelope"></i> Email:
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   class="form-input"
                   placeholder="seu@email.com"
                   value="<?= htmlspecialchars($email ?? ''); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="senha">
                <i class="fas fa-key"></i> Senha:
            </label>
            <input type="password" 
                   id="senha" 
                   name="senha" 
                   class="form-input"
                   placeholder="Digite sua senha"
                   required>
        </div>

        <button type="submit" name="login" class="login-button">
            <i class="fas fa-sign-in-alt"></i> Entrar
        </button>
    </form>

    <div class="login-footer">
        <p>
            <i class="fas fa-shield-alt"></i>
            Seus dados estão protegidos e criptografados
        </p>
    </div>
</div>

<?php include('templates/rodape.php'); ?>
</body>
</html>