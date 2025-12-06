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

// Contar itens por status
$contadorStatus = [
    'disponivel' => 0,
    'devolvido' => 0,
    'arquivado' => 0
];

foreach ($itens as $item) {
    if (isset($contadorStatus[$item['status']])) {
        $contadorStatus[$item['status']]++;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Itens - Administração</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        /* Estilos específicos para gerenciamento */
        .admin-dashboard {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #02416D;
            position: relative;
        }

        .admin-dashboard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #02416D 0%, #CDD071 100%);
        }

        .welcome-admin {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-admin h2 {
            color: #02416D;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .welcome-admin p {
            color: #666;
            font-size: 1.1rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border-left: 4px solid #02416D;
        }

        .stat-card.total {
            border-left-color: #02416D;
        }

        .stat-card.disponivel {
            border-left-color: #28a745;
        }

        .stat-card.devolvido {
            border-left-color: #17a2b8;
        }

        .stat-card.arquivado {
            border-left-color: #6c757d;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #02416D;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .action-btn {
            background: white;
            border: 2px solid #02416D;
            color: #02416D;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-btn:hover {
            background: #02416D;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(2, 65, 109, 0.2);
        }

        .action-btn i {
            font-size: 2.5rem;
        }

        .action-btn.primary {
            background: #02416D;
            color: white;
            border-color: #02416D;
        }

        .action-btn.primary:hover {
            background: #0268A6;
            border-color: #0268A6;
        }

        /* Lista de itens */
        .itens-admin-lista {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-top: 30px;
        }

        .item-admin-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            gap: 25px;
            align-items: flex-start;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 5px solid #02416D;
            position: relative;
        }

        .item-admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .item-admin-imagem {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            border: 3px solid #02416D;
            background: #f8f9fa;
        }

        .item-admin-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .item-admin-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .item-admin-title {
            color: #02416D;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .item-admin-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
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

        .item-admin-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-label {
            color: #02416D;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-label i {
            width: 16px;
            color: #CDD071;
        }

        .detail-value {
            color: #555;
            font-size: 0.95rem;
        }

        .item-admin-actions {
            display: flex;
            gap: 15px;
            margin-top: auto;
        }

        .btn-editar {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-editar:hover {
            background: #218838;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-excluir {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-excluir:hover {
            background: #c82333;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        /* Mensagens */
        .mensagem-sucesso {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mensagem-sucesso i {
            font-size: 1.2rem;
        }

        .mensagem-erro {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mensagem-erro i {
            font-size: 1.2rem;
        }

        /* Mensagem quando não há itens */
        .sem-itens {
            text-align: center;
            padding: 60px 40px;
            background: white;
            border-radius: 15px;
            margin: 40px 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #02416D;
        }

        .sem-itens i {
            font-size: 4rem;
            color: #02416D;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .sem-itens h3 {
            color: #02416D;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .sem-itens p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Título da seção */
        .section-title {
            color: #02416D;
            font-size: 1.8rem;
            margin: 40px 0 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #CDD071;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-title i {
            color: #CDD071;
            font-size: 2rem;
        }

        /* Filtros */
        .filtros-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }

        .filtros-titulo {
            color: #02416D;
            margin-bottom: 15px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filtros-opcoes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filtro-btn {
            padding: 8px 16px;
            background: #f1f3f5;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            color: #666;
        }

        .filtro-btn.active {
            background: #02416D;
            color: white;
        }

        .filtro-btn:hover {
            background: #e9ecef;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .admin-dashboard {
                padding: 30px 20px;
                margin: 20px auto;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .action-buttons {
                grid-template-columns: 1fr;
            }
            
            .item-admin-card {
                flex-direction: column;
                gap: 20px;
            }
            
            .item-admin-imagem {
                width: 100%;
                height: 250px;
            }
            
            .item-admin-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .item-admin-actions {
                width: 100%;
                justify-content: center;
            }
            
            .filtros-opcoes {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .welcome-admin h2 {
                font-size: 1.5rem;
            }
            
            .item-admin-details {
                grid-template-columns: 1fr;
            }
            
            .item-admin-actions {
                flex-direction: column;
            }
            
            .btn-editar, .btn-excluir {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animações */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .item-admin-card {
            animation: slideIn 0.3s ease-out;
            animation-fill-mode: both;
        }

        .item-admin-card:nth-child(1) { animation-delay: 0.1s; }
        .item-admin-card:nth-child(2) { animation-delay: 0.2s; }
        .item-admin-card:nth-child(3) { animation-delay: 0.3s; }
        .item-admin-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <?php include('../templates/cabecalho.php'); ?>

    <div class="container">
        <div class="admin-dashboard">
            <div class="welcome-admin">
                <h2>
                    <i class="fas fa-user-shield"></i> Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['admin_nome']); ?>!
                </h2>
                <p>Área de gerenciamento de itens perdidos e encontrados</p>
            </div>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="mensagem-sucesso">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo htmlspecialchars($_GET['sucesso']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['erro'])): ?>
                <div class="mensagem-erro">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?php echo htmlspecialchars($_GET['erro']); ?></span>
                </div>
            <?php endif; ?>

            <div class="stats-container">
                <div class="stat-card total">
                    <div class="stat-number"><?php echo count($itens); ?></div>
                    <div class="stat-label">Total de Itens</div>
                </div>
                <div class="stat-card disponivel">
                    <div class="stat-number"><?php echo $contadorStatus['disponivel']; ?></div>
                    <div class="stat-label">Disponíveis</div>
                </div>
                <div class="stat-card devolvido">
                    <div class="stat-number"><?php echo $contadorStatus['devolvido']; ?></div>
                    <div class="stat-label">Devolvidos</div>
                </div>
                <div class="stat-card arquivado">
                    <div class="stat-number"><?php echo $contadorStatus['arquivado']; ?></div>
                    <div class="stat-label">Arquivados</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="cadastrar_item.php" class="action-btn primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Cadastrar Novo Item</span>
                </a>
               
                
                <a href="../index.php" class="action-btn">
                    <i class="fas fa-eye"></i>
                    <span>Ver Site Público</span>
                </a>
            </div>
        </div>

        <h2 class="section-title">
            <i class="fas fa-boxes"></i> Itens Cadastrados
            <span class="badge"><?php echo count($itens); ?></span>
        </h2>

        <?php if (count($itens) > 0): ?>
            <!-- Filtros (opcional para futuras implementações) -->
            <!--
            <div class="filtros-container">
                <h3 class="filtros-titulo">
                    <i class="fas fa-filter"></i> Filtrar por Status
                </h3>
                <div class="filtros-opcoes">
                    <button class="filtro-btn active" data-status="todos">Todos (<?php echo count($itens); ?>)</button>
                    <button class="filtro-btn" data-status="disponivel">Disponíveis (<?php echo $contadorStatus['disponivel']; ?>)</button>
                    <button class="filtro-btn" data-status="devolvido">Devolvidos (<?php echo $contadorStatus['devolvido']; ?>)</button>
                    <button class="filtro-btn" data-status="arquivado">Arquivados (<?php echo $contadorStatus['arquivado']; ?>)</button>
                </div>
            </div>
            -->

            <div class="itens-admin-lista">
                <?php foreach ($itens as $item): ?>
                <div class="item-admin-card">
                    <div class="item-admin-imagem">
                        <img src="../img/<?php echo $item['imagem'] ?: 'sem-imagem.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($item['nome']); ?>"
                             onerror="this.src='../img/sem-imagem.jpg'">
                    </div>
                    
                    <div class="item-admin-content">
                        <div class="item-admin-header">
                            <h3 class="item-admin-title"><?php echo htmlspecialchars($item['nome']); ?></h3>
                            <span class="item-admin-status status-<?php echo $item['status']; ?>">
                                <?php 
                                $status_text = [
                                    'disponivel' => 'Disponível',
                                    'devolvido' => 'Devolvido', 
                                    'arquivado' => 'Arquivado'
                                ];
                                echo $status_text[$item['status']]; 
                                ?>
                            </span>
                        </div>
                        
                        <div class="item-admin-details">
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-calendar-day"></i> Encontrado em:
                                </span>
                                <span class="detail-value"><?php echo date('d/m/Y', strtotime($item['dataEncontrado'])); ?></span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i> Local do encontro:
                                </span>
                                <span class="detail-value"><?php echo htmlspecialchars($item['localizacaoEncontrada']); ?></span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-building"></i> Local de busca:
                                </span>
                                <span class="detail-value"><?php echo htmlspecialchars($item['localizacaoBuscar']); ?></span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-tag"></i> Classificação:
                                </span>
                                <span class="detail-value"><?php echo htmlspecialchars($item['tipo']); ?></span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-user-cog"></i> Cadastrado por:
                                </span>
                                <span class="detail-value"><?php echo htmlspecialchars($item['administrador_nome']); ?></span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fas fa-clock"></i> Data do cadastro:
                                </span>
                                <span class="detail-value"><?php echo date('d/m/Y H:i', strtotime($item['dataCadastro'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="item-admin-actions">
                            <a href="editar_item.php?id=<?php echo $item['id_pk']; ?>" class="btn-editar">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="excluir_item.php?id=<?php echo $item['id_pk']; ?>" class="btn-excluir" 
                               onclick="return confirmarExclusao('<?php echo addslashes($item['nome']); ?>')">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="sem-itens">
                <i class="fas fa-box-open"></i>
                <h3>Nenhum item cadastrado ainda</h3>
                <p>Comece cadastrando o primeiro item no sistema.</p>
                <a href="cadastrar_item.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus-circle"></i> Cadastrar Primeiro Item
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Função para confirmar exclusão
        function confirmarExclusao(nomeItem) {
            return confirm(`Tem certeza que deseja excluir o item "${nomeItem}"?\n\nEsta ação não pode ser desfeita.`);
        }

        // Filtros (para implementação futura)
        document.addEventListener('DOMContentLoaded', function() {
            const filtroBtns = document.querySelectorAll('.filtro-btn');
            
            filtroBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filtroBtns.forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Filter logic would go here
                    // const status = this.dataset.status;
                    // filterItems(status);
                });
            });
        });

        // Animação ao rolar
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observar cards para animação
        document.querySelectorAll('.item-admin-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>