<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar item</title>
    <link rel="stylesheet" href="../style.css">






</head>

<body>



    <div class="cadDiv">


        <form action="salvar_item.php" method="POST" enctype="multipart/form-data">

            <h1>Cadastrar Item</h1>

            <label>Nome do item</label>
            <input type="text" name="nome" required>

            <label>Data em que foi encontrado</label>
            <input type="date" name="data" required>

            <label>Local onde foi encontrado</label>
            <input type="text" name="localEncontrado" required>

            <label>Local de busca</label>
            <input type="text" name="localBusca" required>

            <label>Classificação</label>
            <select id="mySelect" name="select">
                <option value="option1">Eletrônico</option>
                <option value="option2">Vestuário</option>
                <option value="option3">Material Escolar</option>
                <option value="option4">Documentação</option>
                <option value="option5">Ferramenta</option>
            </select>

            <label>Imagem</label>
            <input type="file" name="imagem" accept="image/*">

            <button type="submit">Cadastrar Item</button>

            <a href="gerenciar_itens.php" class="btn-voltar2">Retornar</a>

        </form>

    </div>

</body>

</html>