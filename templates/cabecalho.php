<header>
    <h1 id="titulo">Achados e Perdidos</h1>
    <nav>
        <a href="/achadosEperdidosWeb/index.php">Início</a>
        <?php if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true): ?>
            <a href="/achadosEperdidosWeb/adm/gerenciar_itens.php">Gerenciamento</a>
            <span style="color: white;">Olá, <?php echo $_SESSION['admin_nome']; ?></span>
            <a href="/achadosEperdidosWeb/logout.php">Sair</a>
        <?php else: ?>
            <a href="/achadosEperdidosWeb/login.php">Login Admin</a>
        <?php endif; ?>
        <a href="/achadosEperdidosWeb/procurar.php">Procurar</a>
    </nav>
</header>