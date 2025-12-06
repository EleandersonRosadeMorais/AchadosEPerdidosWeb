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

// Verificar se é admin
$isAdmin = isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurar Item - Achados e Perdidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        /* Estilos específicos para a página de busca */
        .search-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #02416D;
            position: relative;
        }

        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #02416D 0%, #CDD071 100%);
        }

        .search-form {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-form label {
            font-weight: 600;
            color: #02416D;
            font-size: 1.1rem;
            white-space: nowrap;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #02416D;
            box-shadow: 0 0 0 3px rgba(2, 65, 109, 0.1);
        }

        .search-button {
            background: #02416D;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .search-button:hover {
            background: #0268A6;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(2, 65, 109, 0.3);
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .btn-voltar {
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

        .btn-voltar:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }

        .search-results-info {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: rgba(205, 208, 113, 0.1);
            border-radius: 10px;
            border-left: 4px solid #CDD071;
        }

        .search-results-info strong {
            color: #02416D;
            font-size: 1.2rem;
        }

        .search-term {
            color: #02416D;
            font-weight: 600;
            font-style: italic;
        }

        /* Ajustes para responsividade */
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-form label {
                text-align: center;
            }
            
            .search-button {
                width: 100%;
                justify-content: center;
            }
            
            .search-container {
                padding: 30px 20px;
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>
<?php include('templates/cabecalho.php'); ?>

<div class="container">
    <div class="search-container">
        <h1 class="page-title">
            <i class="fas fa-search"></i> Procurar Item
        </h1>
        
        <form action="procurar.php" method="GET" class="search-form">
            <label for="pesquisa">Pesquisar:</label>
            <input type="text" 
                   id="pesquisa" 
                   name="pesquisa" 
                   class="search-input"
                   placeholder="Digite o nome do item..." 
                   value="<?= htmlspecialchars($termo); ?>"
                   required>
            
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i> Pesquisar
            </button>
        </form>
        
        <?php if (!empty($termo)): ?>
            <div class="search-results-info">
                <p>
                    <i class="fas fa-info-circle"></i>
                    <strong><?= count($resultados); ?></strong> resultado(s) encontrado(s) para: 
                    <span class="search-term">"<?= htmlspecialchars($termo); ?>"</span>
                </p>
            </div>
            
            <?php if (count($resultados) > 0): ?>
                <div class="itens-grid">
                    <?php foreach ($resultados as $item): ?>
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
                                    <a href="meusitens.php?id=<?= $item['id_pk']; ?>" class="btn btn-primary">
                                        <i class="fas fa-info-circle"></i> Ver Detalhes
                                    </a>
                                    
                                    <div class="item-card-date">
                                        <i class="far fa-calendar-check"></i>
                                        <?= date('d/m/Y', strtotime($item['dataEncontrado'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-message">
                    <div class="empty-icon">🔍</div>
                    <h3>Nenhum item encontrado</h3>
                    <p>Não encontramos itens correspondentes à sua busca.</p>
                    <p>Tente usar outras palavras-chave ou termos mais genéricos.</p>
                    <div class="back-button" style="margin-top: 20px;">
                        <a href="procurar.php" class="btn-voltar">
                            <i class="fas fa-redo"></i> Nova Busca
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="back-button" style="margin-top: 40px;">
                <a href="index.php" class="btn-voltar">
                    <i class="fas fa-arrow-left"></i> Voltar para a Página Inicial
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('templates/rodape.php'); ?>
</body>
</html>