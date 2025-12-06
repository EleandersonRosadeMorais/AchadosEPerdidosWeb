<?php
session_start();
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

// Inicializar variáveis
$nome = $dataEncontrado = $localEncontrado = $localBusca = '';
$erro = isset($_GET['erro']) ? $_GET['erro'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item - Administração</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        /* Estilos específicos para cadastro de item */
        .cadastro-item-container {
            max-width: 700px;
            margin: 60px auto;
            background: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(2, 65, 109, 0.15);
            border-top: 5px solid #02416D;
            position: relative;
        }

        .cadastro-item-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #02416D 0%, #CDD071 100%);
        }

        .cadastro-item-title {
            color: #02416D;
            font-size: 2rem;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #CDD071;
            display: flex;
            align-items: center;
            gap: 15px;
            text-align: center;
            justify-content: center;
        }

        .cadastro-item-subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 40px;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .cadastro-item-form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #02416D;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .form-group label i {
            width: 20px;
            color: #CDD071;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #02416D;
            background: white;
            box-shadow: 0 0 0 3px rgba(2, 65, 109, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        /* Estilo para input de arquivo */
        .file-input-container {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            border: 2px dashed #02416D;
            border-radius: 8px;
            background: rgba(2, 65, 109, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            color: #666;
        }

        .file-input-label:hover {
            background: rgba(2, 65, 109, 0.1);
            border-color: #CDD071;
        }

        .file-input-label i {
            font-size: 2rem;
            color: #02416D;
        }

        .file-name {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }

        /* Botões */
        .btn-cadastrar-item {
            background: #02416D;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
        }

        .btn-cadastrar-item:hover {
            background: #0268A6;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(2, 65, 109, 0.3);
        }

        /* Mensagens de erro */
        .mensagem-erro {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mensagem-erro i {
            font-size: 1.2rem;
        }

        /* Botões de ação */
        .acao-botoes {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #eee;
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
            flex: 1;
            justify-content: center;
            text-align: center;
        }

        .btn-voltar:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }

        .btn-limpar {
            background: #CDD071;
            color: #02416D;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            flex: 1;
            justify-content: center;
            text-align: center;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-family: inherit;
        }

        .btn-limpar:hover {
            background: #e8ecaa;
            transform: translateY(-3px);
        }

        /* Validação visual */
        .form-input.valid {
            border-color: #28a745;
        }

        .form-input.invalid {
            border-color: #dc3545;
        }

        /* Informações do formulário */
        .form-info {
            background: rgba(205, 208, 113, 0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #CDD071;
            margin: 20px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .form-info i {
            color: #02416D;
            margin-right: 8px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .cadastro-item-container {
                margin: 40px 20px;
                padding: 40px 25px;
            }
            
            .cadastro-item-title {
                font-size: 1.8rem;
            }
            
            .acao-botoes {
                flex-direction: column;
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .cadastro-item-container {
                padding: 30px 20px;
            }
            
            .cadastro-item-title {
                font-size: 1.6rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .cadastro-item-subtitle {
                font-size: 1rem;
            }
            
            .form-group label {
                font-size: 1rem;
            }
            
            .form-input, .form-select {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
<?php include('../templates/cabecalho.php'); ?>

<div class="cadastro-item-container">
    <h1 class="cadastro-item-title">
        <i class="fas fa-plus-circle"></i> Cadastrar Item Perdido
    </h1>
    
    <p class="cadastro-item-subtitle">
        Preencha os dados abaixo para cadastrar um novo item encontrado no sistema.
        Campos marcados com * são obrigatórios.
    </p>

    <?php if (!empty($erro)): ?>
        <div class="mensagem-erro">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo htmlspecialchars($erro); ?></span>
        </div>
    <?php endif; ?>

    <div class="form-info">
        <i class="fas fa-info-circle"></i>
        Após o cadastro, o item ficará disponível para visualização pública na página inicial.
    </div>

    <form action="salvar_item.php" method="POST" enctype="multipart/form-data" class="cadastro-item-form" id="formCadastroItem">
        <div class="form-group">
            <label for="nome">
                <i class="fas fa-box"></i> Nome do Item: *
            </label>
            <input type="text" 
                   id="nome" 
                   name="nome" 
                   class="form-input"
                   placeholder="Ex: Celular, Carteira, Chaves..."
                   value="<?= htmlspecialchars($nome); ?>"
                   required
                   minlength="3"
                   maxlength="100">
        </div>

        <div class="form-group">
            <label for="data">
                <i class="fas fa-calendar-day"></i> Data em que foi encontrado: *
            </label>
            <input type="date" 
                   id="data" 
                   name="data" 
                   class="form-input"
                   value="<?= htmlspecialchars($dataEncontrado); ?>"
                   required
                   max="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="form-group">
            <label for="localEncontrado">
                <i class="fas fa-map-marker-alt"></i> Local onde foi encontrado: *
            </label>
            <input type="text" 
                   id="localEncontrado" 
                   name="localEncontrado" 
                   class="form-input"
                   placeholder="Ex: Biblioteca, Sala 101, Corredor A..."
                   value="<?= htmlspecialchars($localEncontrado); ?>"
                   required
                   minlength="3"
                   maxlength="200">
        </div>

        <div class="form-group">
            <label for="localBusca">
                <i class="fas fa-building"></i> Local de busca: *
            </label>
            <input type="text" 
                   id="localBusca" 
                   name="localBusca" 
                   class="form-input"
                   placeholder="Ex: Secretaria, Portaria, Sala 201..."
                   value="<?= htmlspecialchars($localBusca); ?>"
                   required
                   minlength="3"
                   maxlength="200">
        </div>

        <div class="form-group">
            <label for="select">
                <i class="fas fa-tag"></i> Classificação: *
            </label>
            <select id="select" name="select" class="form-select" required>
                <option value="">Selecione uma classificação...</option>
                <option value="Eletrônico" <?= $select ?? '' == 'Eletrônico' ? 'selected' : '' ?>>Eletrônico</option>
                <option value="Vestuário" <?= $select ?? '' == 'Vestuário' ? 'selected' : '' ?>>Vestuário</option>
                <option value="Material Escolar" <?= $select ?? '' == 'Material Escolar' ? 'selected' : '' ?>>Material Escolar</option>
                <option value="Documentação" <?= $select ?? '' == 'Documentação' ? 'selected' : '' ?>>Documentação</option>
                <option value="Ferramenta" <?= $select ?? '' == 'Ferramenta' ? 'selected' : '' ?>>Ferramenta</option>
                <option value="Outros" <?= $select ?? '' == 'Outros' ? 'selected' : '' ?>>Outros</option>
            </select>
        </div>

        <div class="form-group">
            <label>
                <i class="fas fa-camera"></i> Imagem (Opcional):
            </label>
            <div class="file-input-container">
                <input type="file" 
                       id="imagem" 
                       name="imagem" 
                       class="file-input"
                       accept="image/*">
                <label for="imagem" class="file-input-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Clique para selecionar uma imagem</span>
                </label>
            </div>
            <div id="file-name" class="file-name">
                <i class="fas fa-info-circle"></i> Formatos suportados: JPG, PNG, GIF. Máximo: 5MB
            </div>
        </div>

        <button type="submit" class="btn-cadastrar-item">
            <i class="fas fa-save"></i> Cadastrar Item
        </button>

        <div class="acao-botoes">
            <a href="../index.php" class="btn-voltar">
                <i class="fas fa-arrow-left"></i> Voltar para Gerenciamento
            </a>
            
            <button type="button" class="btn-limpar" onclick="limparFormulario()">
                <i class="fas fa-eraser"></i> Limpar Formulário
            </button>
        </div>
    </form>
</div>

<?php include('../templates/rodape.php'); ?>

<script>
    // Mostrar nome do arquivo selecionado
    document.getElementById('imagem').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Nenhum arquivo selecionado';
        document.getElementById('file-name').innerHTML = `<i class="fas fa-file-image"></i> ${fileName}`;
    });

    // Validação de arquivo
    document.getElementById('imagem').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            if (file.size > maxSize) {
                alert('A imagem deve ter no máximo 5MB');
                this.value = '';
                document.getElementById('file-name').innerHTML = '<i class="fas fa-info-circle"></i> Formatos suportados: JPG, PNG, GIF. Máximo: 5MB';
                return;
            }
            
            if (!allowedTypes.includes(file.type)) {
                alert('Por favor, selecione uma imagem (JPEG, PNG, GIF ou WebP)');
                this.value = '';
                document.getElementById('file-name').innerHTML = '<i class="fas fa-info-circle"></i> Formatos suportados: JPG, PNG, GIF. Máximo: 5MB';
                return;
            }
        }
    });

    // Validação em tempo real
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.remove('valid', 'invalid');
            } else if (this.checkValidity()) {
                this.classList.remove('invalid');
                this.classList.add('valid');
            } else {
                this.classList.remove('valid');
                this.classList.add('invalid');
            }
        });
        
        input.addEventListener('input', function() {
            this.classList.remove('valid', 'invalid');
        });
    });

    // Função para limpar formulário
    function limparFormulario() {
        if (confirm('Tem certeza que deseja limpar todos os campos do formulário?')) {
            document.getElementById('formCadastroItem').reset();
            inputs.forEach(input => {
                input.classList.remove('valid', 'invalid');
            });
            document.getElementById('file-name').innerHTML = '<i class="fas fa-info-circle"></i> Formatos suportados: JPG, PNG, GIF. Máximo: 5MB';
            
            // Mostrar mensagem de confirmação
            const mensagem = document.createElement('div');
            mensagem.className = 'mensagem-sucesso';
            mensagem.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1000;';
            mensagem.innerHTML = '<i class="fas fa-check-circle"></i> Formulário limpo com sucesso!';
            document.body.appendChild(mensagem);
            
            setTimeout(() => mensagem.remove(), 3000);
        }
    }

    // Limitar data máxima para hoje
    document.getElementById('data').max = new Date().toISOString().split('T')[0];

    // Validação do formulário
    document.getElementById('formCadastroItem').addEventListener('submit', function(e) {
        let valid = true;
        
        // Validar campos obrigatórios
        const requiredFields = this.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('invalid');
                valid = false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios corretamente.');
            return false;
        }
        
        // Validar arquivo se selecionado
        const fileInput = document.getElementById('imagem');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const maxSize = 5 * 1024 * 1024;
            
            if (file.size > maxSize) {
                e.preventDefault();
                alert('A imagem selecionada excede o tamanho máximo de 5MB.');
                return false;
            }
        }
        
        // Mostrar loading
        const submitBtn = this.querySelector('.btn-cadastrar-item');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cadastrando...';
        submitBtn.disabled = true;
        
        // Reverter após 5 segundos (caso algo dê errado)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
</script>
</body>
</html>