<?php
session_start();
require_once('./db/conexao_db.php');
require_once('./db/tab_item.php');

$database = new Database();
$db = $database->getConnection();
$itemPerdido = new ItemPerdido($db);

$itens = $itemPerdido->buscarPorStatus('disponivel');

// Verificar se é admin
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
<?php include('templates/cabecalho.php'); ?>

<div class="container">
    <?php if($isAdmin): ?>
        <div class="admin-welcome">
            <i class="fas fa-user-shield"></i>
            <div>
                <strong>Bem-vindo, <?php echo htmlspecialchars($adminNome); ?>!</strong>
                <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #666;">
                    Você está logado como administrador
                </p>
            </div>
        </div>
    <?php endif; ?>
    
    <h1 class="page-title">
        <i class="fas fa-box-open"></i> Itens Encontrados
        <span class="badge"><?php echo count($itens); ?></span>
    </h1>
    
    <?php if (count($itens) > 0): ?>
        <div class="itens-grid">
            <?php foreach ($itens as $item): ?>
                <div class="item-card">
                    <div class="item-card-image">
                        <?php if (!empty($item['imagem']) && $item['imagem'] != 'sem-imagem.jpg'): ?>
                            <img src="./img/<?php echo $item['imagem']; ?>" 
                                 alt="<?php echo htmlspecialchars($item['nome']); ?>"
                                 onerror="this.src='./img/sem-imagem.jpg'">
                        <?php else: ?>
                            <div class="no-image">
                                <i class="fas fa-box-open"></i>
                            </div>
                        <?php endif; ?>
                        <div class="item-card-type">
                            <i class="fas fa-tag"></i> <?php echo $item['tipo']; ?>
                        </div>
                    </div>
                    
                    <div class="item-card-content">
                        <h3 class="item-card-title"><?php echo htmlspecialchars($item['nome']); ?></h3>
                        
                        <div class="item-card-details">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Encontrado em:</strong>
                                    <span><?php echo $item['localizacaoEncontrada']; ?></span>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <i class="fas fa-building"></i>
                                <div>
                                    <strong>Buscar em:</strong>
                                    <span><?php echo $item['localizacaoBuscar']; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="item-card-footer">
                            <a href="meusitens.php?id=<?php echo $item['id_pk']; ?>" class="btn btn-primary">
                                <i class="fas fa-info-circle"></i> Ver Detalhes
                            </a>
                            
                            <div class="item-card-date">
                                <i class="far fa-calendar-check"></i>
                                <?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-message">
            <div class="empty-icon">📦</div>
            <h3>Nenhum item disponível no momento</h3>
            <p>Volte mais tarde para verificar novos itens encontrados.</p>
            <?php if($isAdmin): ?>
                <a href="cadastro_item.php" class="btn btn-primary" style="margin-top: 15px;">
                    <i class="fas fa-plus-circle"></i> Cadastrar Primeiro Item
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('templates/rodape.php'); ?>
</body>
</html>