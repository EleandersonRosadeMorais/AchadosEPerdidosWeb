<?php
require_once('../db/conexao_db.php');
require_once('../db/tab_item.php');

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar item</title>
</head>

<body>
    <form action="salvar_edicao.php" method="POST">
        
        <label for="novo_nome">Novo nome do item:</label>
        <input type="text" id="novo_nome" name="novo_nome" required value="<?php echo htmlspecialchars( $item["nome"])?>">

        <label for="nova_data">Nova data:</label>
        <input type="text" id="nova_data" name="nova_data" required value="<?php echo htmlspecialchars($item['dataEncontrado'])?>">

        <label for="novo_local_encontrado">Novo local que foi encontrado:</label>
        <input type="text" id="novo_local_encontrado" id="novo_local_encontrado" name="novo_local_encontrado" required value="<?php echo htmlspecialchars($item['localizacaoEncontrada'])?>">

        <label for="novo_local_busca">Novo local de busca:</label>
        <input type="text" id="novo_local_busca" id="novo_local_busca" name="novo_local_busca" required value="<?php echo htmlspecialchars($item['localizacaoBuscar'])?>">

        <label>Classificação</label>
            <select name="tipo_editar" required>
                <option value="Eletrônico">Eletrônico</option>
                <option value="Vestuário">Vestuário</option>
                <option value="Material Escolar">Material Escolar</option>
                <option value="Documentação">Documentação</option>
                <option value="Ferramenta">Ferramenta</option>
            </select>

            <label>Imagem</label>
            <input type="file" name="imagem_editar" accept="image/*">

            <label>Status:</label>
            <select name="status_editar"  required>
            <option value="disponivel">disponivel</option>
            <option value="devolvido">devolvido</option>
            <option value="arquivado"></option>
            </select>

            <button type="submit">Salvar alterações</button>
    </form>


</body>

</html>