<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

<?php include('templates/cabecalho.php'); ?>

<div class="container2">
        <form action="resultado.php" method="GET">
            <label for="pesquisa">Pesquisar item:</label>
            <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o nome do item...">

            <button type="submit" id="pesquisar">Pesquisar</button>
        </form>
    </div>

    
</body>
</html>