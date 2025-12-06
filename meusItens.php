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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        /* Estilos específicos para detalhes do item */
        .item-detail-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #02416D;
            position: relative;
        }

        .item-detail-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #02416D 0%, #CDD071 100%);
        }

        .item-detail-content {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        @media (max-width: 768px) {
            .item-detail-content {
                flex-direction: column;
            }
        }

        .item-detail-image {
            flex: 1;
            max-width: 400px;
        }

        .item-detail-image img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 15px;
            border: 3px solid #02416D;
            box-shadow: 0 8px 25px rgba(2, 65, 109, 0.2);
        }

        .item-detail-info {
            flex: 2;
        }

        .item-detail-title {
            color: #02416D;
            font-size: 2rem;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #CDD071;
        }

        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        .detail-list li {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #02416D;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
            min-width: 220px;
        }

        .detail-label i {
            width: 20px;
            text-align: center;
        }

        .detail-value {
            color: #555;
            font-size: 1.1rem;
            line-height: 1.6;
            padding-left: 30px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-disponivel {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid #28a745;
        }

        .status-devolvido {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid #17a2b8;
        }

        .status-arquivado {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .btn-voltar {
            background: #02416D;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-voltar:hover {
            background: #0268A6;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(2, 65, 109, 0.3);
        }

        .item-date {
            color: #666;
            font-style: italic;
            background: rgba(205, 208, 113, 0.1);
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .item-date i {
            color: #CDD071;
        }
    </style>
</head>
<body>
<?php include('templates/cabecalho.php'); ?>

<div class="container">
    <div class="item-detail-container">
        <div class="item-detail-content">
            <div class="item-detail-image">
                <img src="./img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" 
                     alt="<?php echo htmlspecialchars($item['nome']); ?>"
                     onerror="this.src='./img/sem-imagem.jpg'">
            </div>
            
            <div class="item-detail-info">
                <h1 class="item-detail-title">
                    <i class="fas fa-box-open"></i> <?php echo htmlspecialchars($item['nome']); ?>
                </h1>

                <ul class="detail-list">
                    <li>
                        <div class="detail-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Local Encontrado:
                        </div>
                        <div class="detail-value"><?php echo htmlspecialchars($item['localizacaoEncontrada']); ?></div>
                    </li>
                    
                    <li>
                        <div class="detail-label">
                            <i class="fas fa-tag"></i>
                            Tipo do Item:
                        </div>
                        <div class="detail-value"><?php echo htmlspecialchars($item['tipo']); ?></div>
                    </li>
                    
                    <li>
                        <div class="detail-label">
                            <i class="fas fa-building"></i>
                            Local de Busca:
                        </div>
                        <div class="detail-value"><?php echo htmlspecialchars($item['localizacaoBuscar']); ?></div>
                    </li>
                    
                    <li>
                        <div class="detail-label">
                            <i class="fas fa-info-circle"></i>
                            Status:
                        </div>
                        <div class="detail-value">
                            <?php 
                            $status_text = [
                                'disponivel' => 'Disponível para retirada',
                                'devolvido' => 'Item já foi devolvido', 
                                'arquivado' => 'Item arquivado'
                            ];
                            
                            $status_class = [
                                'disponivel' => 'status-disponivel',
                                'devolvido' => 'status-devolvido',
                                'arquivado' => 'status-arquivado'
                            ];
                            
                            echo '<span class="status-badge ' . $status_class[$item['status']] . '">';
                            echo '<i class="fas ' . ($item['status'] == 'disponivel' ? 'fa-check-circle' : 
                                ($item['status'] == 'devolvido' ? 'fa-handshake' : 'fa-archive')) . '"></i>';
                            echo $status_text[$item['status']];
                            echo '</span>';
                            ?>
                        </div>
                    </li>
                    
                    <?php if ($item['administrador_nome']): ?>
                    <li>
                        <div class="detail-label">
                            <i class="fas fa-user-cog"></i>
                            Cadastrado por:
                        </div>
                        <div class="detail-value"><?php echo htmlspecialchars($item['administrador_nome']); ?></div>
                    </li>
                    <?php endif; ?>
                </ul>

                <div class="item-actions">
                    <a href="index.php" class="btn-voltar">
                        <i class="fas fa-arrow-left"></i> Voltar para Itens
                    </a>
                    
                    <span class="item-date">
                        <i class="far fa-calendar-check"></i>
                        Encontrado em: <?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('templates/rodape.php'); ?>
</body>
</html>