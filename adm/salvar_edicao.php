<?php
session_start();
require_once('../db/conexao_db.php');
require_once('../db/tab_item.php');


if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: gerenciar_itens.php');
    exit();
}
if ($_POST['REQUEST_METHOD'] == 'POST') {
     try{
    $database = new Database();
    $db = $database->getConnection();
    $itemPerdido = new ItemPerdido($db);

    $id_item = $_GET['id']; 

    $novo_nome = $_POST['novo_nome'];
    $nova_data = $_POST['nova_data'];
    $novo_local_encontrado = $_POST['nova_local_encontrado'];
    $novo_local_busca = $_POST['novo_local_busca'];
    $tipo_editar = $_POST['tipo_editar'];
    $status_editar = $_POSt['status_editar'];

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


        if ($itemPerdido->atualizar($id_item, 
        $novo_nome, 
        $nova_data, 
        $novo_local_encontrado, 
        $novo_local_busca, 
        $tipo_editar, 
        $imagem_editar, 
        $status_editar)) {
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
