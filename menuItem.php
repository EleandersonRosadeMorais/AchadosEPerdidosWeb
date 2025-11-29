<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Item</title>
    <link rel="stylesheet" href="style.css">
    
</head>


<body>
    
<?php include('templates/cabecalho.php'); ?>


<div class="item-container">
    <h2 class="titulo-pagina">Informações do Item</h2>

    <div class="card-item">
        
        <div class="item-img">
            <img src="./img/garrafa.jpg" alt="">
        </div>

        
        <div class="item-info">
            <h3 class="itemNome">Chaleira</h3>

            <div class="info">
            <h3><strong>Local onde foi encontrado:</strong> Cafeteria</h3>
            <h3><strong>Tipo do Item:</strong> Documento</h3>
            <h3><strong>Local de busca:</strong> Secretaria</h3>
            </div>

            <div class="info-footer">
                <a href="index.php" class="btn-voltar">Voltar</a>

                <span class="data-encontrado">Encontrado em: 12/11/2025</span>
            </div>
        </div>

    </div>

</div>


</body>
</html>