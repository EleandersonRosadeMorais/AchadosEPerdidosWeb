<?php
session_start();
require_once('../db/conexao_db.php');
require_once('../db/tab_item.php');

if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $itemPerdido = new ItemPerdido($db);

        $nome = $_POST['nome'];
        $dataEncontrado = $_POST['data'];
        $localizacaoEncontrada = $_POST['localEncontrado'];
        $localizacaoBuscar = $_POST['localBusca'];
        $tipo = $_POST['select'];
        $administrador_fk = $_SESSION['admin_id'];

        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $diretorio_img = "../img/";
            if (!is_dir($diretorio_img)) {
                mkdir($diretorio_img, 0777, true);
            }
            
            $nome_imagem = uniqid() . '_' . $_FILES['imagem']['name'];
            $caminho_completo = $diretorio_img . $nome_imagem;
            
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
                $imagem = $nome_imagem;
            }
        }

        if ($itemPerdido->criar($nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem, $administrador_fk)) {
            header('Location: gerenciar_itens.php?sucesso=Item cadastrado com sucesso!');
        } else {
            header('Location: cadastrar_item.php?erro=Erro ao cadastrar item');
        }

    } catch (PDOException $e) {
        header('Location: cadastrar_item.php?erro=Erro no sistema: ' . $e->getMessage());
    }
} else {
    header('Location: cadastrar_item.php');
}
?>