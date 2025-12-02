<header>
    <h1 id="titulo">Achados e Perdidos</h1>
    <nav>
        <a href="/achadosEperdidosWeb/index.php">Início</a>
        <a href="/achadosEperdidosWeb/procurar.php">Procurar</a>
        <?php if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true): ?>
            <a href="/achadosEperdidosWeb/adm/gerenciar_itens.php">Gerenciamento</a>
            <a href="/achadosEperdidosWeb/logout.php">Sair</a>
            <span">Olá, <?php echo $_SESSION['admin_nome']; ?></span>
        <?php else: ?>
            <a href="/achadosEperdidosWeb/login.php">Login Admin</a>
            
        <?php endif; ?>
        
        
    </nav>
</header>