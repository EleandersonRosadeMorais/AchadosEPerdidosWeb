<?php
session_start();

require_once "db/conexao_db.php";
require_once "db/tab_item.php";

$termo = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : "";

$resultados = [];

if (!empty($termo)) {
    $database = new Database();
    $db = $database->getConnection();

    $itemObj = new ItemPerdido($db);
    $resultados = $itemObj->buscarPorNome($termo);
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurar</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

<?php include('templates/cabecalho.php'); ?>

<div class="container2">
        <form action="procurar.php" method="GET">
            <label for="pesquisa">Pesquisar item:</label>
            <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o nome do item..." value="<?= htmlspecialchars($termo); ?>">

            <button type="submit" id="pesquisar">Pesquisar</button>
        </form>
    </div>



    <?php if (!empty($termo)): ?>
    <h1 class="rotItens">Resultados da Busca (<?= count($resultados); ?>)</h1>

    <?php if (count($resultados) > 0): ?>
        <?php foreach ($resultados as $item): ?>
            <div class="card-item2">
                <div class="item-img2">
                    <img src="./img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" 
                         alt="<?php echo $item['nome']; ?>" 
                         onerror="this.src='./img/sem-imagem.jpg'">
                </div>

                <div class="item-info2">
                    <h3 class="itemNome"><?= htmlspecialchars($item['nome']); ?></h3>

                    <div class="info2">
                        <label><strong>Tipo de Item: </strong><?= $item['tipo']; ?></label>
                        <label><strong>Local Encontrado: </strong><?= $item['localizacaoEncontrada']; ?></label>
                        <label><strong>Buscar em: </strong><?= $item['localizacaoBuscar']; ?></label>
                    </div>

                    <div class="info-footer2">
                        <a href="menuItem.php?id=<?= $item['id_pk']; ?>" class="btn-visualizar">
                            Visualizar Detalhes
                        </a>
                        <span class="data-encontrado">
                            Encontrado em: <?= date('d/m/Y', strtotime($item['dataEncontrado'])); ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p style="text-align:center; margin:20px;">Nenhum item encontrado.</p>
    <?php endif; ?>

<?php endif; ?>
    
</body>
</html>