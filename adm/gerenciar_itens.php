<?php
session_start();
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

require_once('../db/conexao_db.php');
require_once('../db/tab_item.php');

$database = new Database();
$db = $database->getConnection();
$itemPerdido = new ItemPerdido($db);

$itens = $itemPerdido->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Itens - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include('../templates/cabecalho.php'); ?>

    <div class="container">

        <div class="divGerenciamento">
        <h2>Bem-Vindo(a) a Área de Gerenciamento, <?php echo $_SESSION['admin_nome']; ?></h2>
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="sucesso"><?php echo $_GET['sucesso']; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="erro"><?php echo $_GET['erro']; ?></div>
        <?php endif; ?>

        <div class="divButton">
            <a href="cadastrar_item.php" class="btn">Cadastrar Novo Item</a>
            <a href="../register.php" class="btn">Cadastrar Administrador</a>
            <a href="../index.php" class="btn">Ver Site Público</a>
        </div>
        
        </div>

        <h3>Itens Cadastrados (<?php echo count($itens); ?>)</h3>
        
        <div class="lista-itens">
            <?php if (count($itens) > 0): ?>
                <?php foreach ($itens as $item): ?>
                <div class="item-card">
                    <div class="item-imagem">
                        <img src="../img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($item['nome']); ?>"
                             onerror="this.src='../img/sem-imagem.jpg'">
                    </div>
                    
                    <div class="item-info">
                        <h4><?php echo htmlspecialchars($item['nome']); ?></h4>
                        <p><strong>Encontrado em:</strong> <?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?></p>
                        <p><strong>Local do encontro:</strong> <?php echo htmlspecialchars($item['localizacaoEncontrada']); ?></p>
                        <p><strong>Local de busca:</strong> <?php echo htmlspecialchars($item['localizacaoBuscar']); ?></p>
                        <p><strong>Classificação:</strong> <?php echo htmlspecialchars($item['tipo']); ?></p>
                        <p><strong>Status:</strong> 
                            <span class="status-<?php echo $item['status']; ?>">
                                <?php 
                                $status_text = [
                                    'disponivel' => 'Disponível',
                                    'devolvido' => 'Devolvido', 
                                    'arquivado' => 'Arquivado'
                                ];
                                echo $status_text[$item['status']]; 
                                ?>
                            </span>
                        </p>
                        <p><strong>Cadastrado por:</strong> <?php echo htmlspecialchars($item['administrador_nome']); ?></p>
                        <p><strong>Data do cadastro:</strong> <?php echo date('d/m/Y H:i', strtotime($item['dataCadastro'])); ?></p>
                    </div>
                    
                    <div class="item-actions">
                        <a href="editar_item.php?id=<?php echo $item['id_pk']; ?>" class="btn-editar">Editar</a>
                        <a href="excluir_item.php?id=<?php echo $item['id_pk']; ?>" class="btn-excluir" 
                           onclick="return confirm('Tem certeza que deseja excluir o item \'<?php echo addslashes($item['nome']); ?>\'?')">
                           Excluir
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="sem-itens">
                    <p>Nenhum item cadastrado ainda.</p>
                    <p>Clique em "Cadastrar Novo Item" para adicionar o primeiro item.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>