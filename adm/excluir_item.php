<?php
session_start();
require_once('../db/conexao_db.php');
require_once('../db/tab_item.php');

if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $itemPerdido = new ItemPerdido($db);

        $id = $_GET['id'];
        
        $item = $itemPerdido->buscarPorId($id);
        
        if ($itemPerdido->excluir($id)) {
            if ($item && $item['imagem'] && file_exists('../img/' . $item['imagem'])) {
                unlink('../img/' . $item['imagem']);
            }
            header('Location: gerenciar_itens.php?sucesso=Item excluído com sucesso!');
        } else {
            header('Location: gerenciar_itens.php?erro=Erro ao excluir item');
        }

    } catch (PDOException $e) {
        header('Location: gerenciar_itens.php?erro=Erro no sistema: ' . $e->getMessage());
    }
} else {
    header('Location: gerenciar_itens.php');
}
?>