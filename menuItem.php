<?php
require_once('db/conexao_db.php');
require_once('db/tab_item.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();
$itemPerdido = new ItemPerdido($db);

$item = $itemPerdido->buscarPorId($_GET['id']);

if (!$item) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($item['nome']); ?> - Achados e Perdidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('templates/cabecalho.php'); ?>

    <div class="item-container">
        <h2 class="titulo-pagina">Informações do Item</h2>

        <div class="card-item">
            <div class="item-img">
                <img src="./img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" 
                     alt="<?php echo htmlspecialchars($item['nome']); ?>"
                     onerror="this.src='./img/sem-imagem.jpg'">
            </div>
            
            <div class="item-info">
                <h3 class="itemNome"><?php echo htmlspecialchars($item['nome']); ?></h3>

                <div class="info">
                    <p><strong>Local onde foi encontrado:</strong> <?php echo htmlspecialchars($item['localizacaoEncontrada']); ?></p>
                    <p><strong>Tipo do Item:</strong> <?php echo htmlspecialchars($item['tipo']); ?></p>
                    <p><strong>Local de busca:</strong> <?php echo htmlspecialchars($item['localizacaoBuscar']); ?></p>
                    <p><strong>Status:</strong> 
                        <?php 
                        $status_text = [
                            'disponivel' => 'Disponível para retirada',
                            'devolvido' => 'Item já foi devolvido', 
                            'arquivado' => 'Item arquivado'
                        ];
                        echo $status_text[$item['status']]; 
                        ?>
                    </p>
                    <?php if ($item['administrador_nome']): ?>
                        <p><strong>Cadastrado por:</strong> <?php echo htmlspecialchars($item['administrador_nome']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="info-footer">
                    <a href="index.php" class="btn-voltar">Voltar</a>
                    <span class="data-encontrado">Encontrado em: <?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>