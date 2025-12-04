<?php
// api/item.php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

include_once "../db/conexao_db.php";
include_once "../db/config.php";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // URL base para imagens
    $url_base = "https://ac.infinitydev.com.br/img/";
    
    // Pega o ID da URL (ex: api/item.php?id=1)
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id <= 0) {
        // Se não informou ID válido, retorna erro
        echo json_encode(["erro" => "ID não informado ou inválido"]);
        exit();
    }
    
    // Busca APENAS o item com o ID especificado
    $query = "SELECT * FROM itemPerdido WHERE id_pk = :id AND status = 'disponivel'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Formata o item como um objeto único
        $item = array(
            "id" => (int)$row['id_pk'],
            "nome" => $row['nome'],
            "data_encontrado" => $row['dataEncontrado'],
            "local_encontrado" => $row['localizacaoEncontrada'],
            "local_buscar" => $row['localizacaoBuscar'],
            "tipo" => $row['tipo'],
            "administrador_fk" => (int)$row['administrador_fk'],
            "status" => $row['status'],
            "data_cadastro" => $row['dataCadastro']
        );
        
        // Adiciona URL da imagem se existir
        if (!empty($row['imagem'])) {
            $item['imagem'] = $url_base . $row['imagem'];
        } else {
            $item['imagem'] = null;
        }
        
        // Retorna APENAS UM objeto (igual exemplo do CEP)
        echo json_encode($item, JSON_UNESCAPED_UNICODE);
        
    } else {
        // Se não encontrou o item
        echo json_encode(["erro" => "Item não encontrado ou indisponível"]);
    }
    
} catch (Exception $e) {
    echo json_encode(["erro" => "Falha ao carregar item"]);
}