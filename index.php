<?php
session_start();
require_once('db/conexao_db.php');
require_once('db/tab_item.php');

$database = new Database();
$db = $database->getConnection();
$itemPerdido = new ItemPerdido($db);

$itens = $itemPerdido->buscarPorStatus('disponivel');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Achados e Perdidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('templates/cabecalho.php'); ?>

    <h1 class="sobre">Sobre o site</h1>

    <div class="saudacao">
        <h1>Bem-vindo ao Portal de Achados e Perdidos</h1>
        <p>
            Nosso objetivo é ajudar pessoas a encontrarem itens perdidos da forma mais rápida e simples possível.
            Aqui você pode registrar objetos que encontrou ou procurar por algo que tenha perdido.
            Navegue pelo site, veja os itens cadastrados e contribua para que outros também recuperem seus pertences!
        </p>
    </div>

    <h1 class="rotItens">Itens Encontrados (<?php echo count($itens); ?>)</h1>

    <?php if (count($itens) > 0): ?>
        <?php foreach ($itens as $item): ?>
        <div class="card-item2">
            <div class="item-img2">
                <img src="./img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" alt="<?php echo $item['nome']; ?>" 
                     onerror="this.src='./img/sem-imagem.jpg'">
            </div>
            
            <div class="item-info2">
                <h3 class="itemNome"><?php echo htmlspecialchars($item['nome']); ?></h3>

                <div class="info2">
                    <label><strong>Tipo de Item: </strong><?php echo $item['tipo']; ?></label>
                    <label><strong>Local Encontrado: </strong><?php echo $item['localizacaoEncontrada']; ?></label>
                    <label><strong>Buscar em: </strong><?php echo $item['localizacaoBuscar']; ?></label>
                </div>

                <div class="info-footer2">
                    <a href="menuItem.php?id=<?php echo $item['id_pk']; ?>" class="btn-visualizar">Visualizar Detalhes</a>
                    <span class="data-encontrado">Encontrado em: <?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align: center; margin: 20px;">
            <p>Nenhum item disponível no momento.</p>
        </div>
    <?php endif; ?>

    <?php include('templates/rodape.php'); ?>
</body>
</html>