<?php
// Verificar se está logado como admin
$isAdmin = isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true;
$adminNome = isset($_SESSION['admin_nome']) ? $_SESSION['admin_nome'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Achados e Perdidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header class="main-header">
    <div class="header-content">
        <a href="index.php" class="logo-link">
            <i class="fas fa-box-open"></i>
            Achados e Perdidos
        </a>
        
        <nav>
            <ul class="nav-list">
                <!-- Sempre visível -->
                <li><a href="index.php"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="procurar.php"><i class="fas fa-search"></i> Procurar</a></li>
                
                <?php if($isAdmin): ?>
                    <!-- Apenas para admins logados -->
                    <li><a href="adm/cadastrar_item.php"><i class="fas fa-plus-circle"></i> Cadastrar Item</a></li>
                    <li><a href="adm/gerenciar_itens.php"><i class="fas fa-cogs"></i> Gerenciar</a></li>
                    
                    <li class="nav-dropdown">
                        <a href="#" class="user-menu">
                            <i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($adminNome); ?>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fas fa-user-cog"></i> Perfil</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                        </ul>
                    </li>
                    
                <?php else: ?>
                    <!-- Apenas para não logados -->
                    <li><a href="login.php" class="register-btn">
                        <i class="fas fa-sign-in-alt"></i> Login Admin
                    </a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>