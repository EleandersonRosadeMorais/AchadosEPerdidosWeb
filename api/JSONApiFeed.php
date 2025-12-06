<?php
// NO TOPO do arquivo, antes de qualquer coisa
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

include_once "../db/conexao_db.php";
include_once "../db/config.php";

try {
    $database = new Database();
    $conn = $database->getConnection();

    $url_base = "https://ap.infinitydev.com.br/img/";
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        echo json_encode(["erro" => "ID não informado ou inválido"]);
        exit();
    }

    // Query - FORÇAR charset na query também
    $query = "SELECT 
                id_pk,
                CONVERT(nome USING utf8mb4) as nome,
                dataEncontrado,
                CONVERT(localizacaoEncontrada USING utf8mb4) as localizacaoEncontrada,
                CONVERT(localizacaoBuscar USING utf8mb4) as localizacaoBuscar,
                CONVERT(tipo USING utf8mb4) as tipo,
                administrador_fk,
                status,
                dataCadastro,
                imagem
              FROM itemPerdido 
              WHERE id_pk = :id AND status = 'disponivel'";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // FUNÇÃO PARA CONVERTER QUALQUER DADO PROBLEMÁTICO
        function garantirUTF8($dado)
        {
            if (is_string($dado)) {
                // Se parece com dados binários (\x ou \z)
                if (strpos($dado, '\\x') !== false || strpos($dado, '\\z') !== false) {
                    // Tentar decodificar como string literal
                    $dado = stripcslashes($dado);
                }

                // Verificar se já é UTF-8 válido
                if (!mb_check_encoding($dado, 'UTF-8')) {
                    $dado = mb_convert_encoding($dado, 'UTF-8', 'UTF-8,ISO-8859-1,ASCII,Windows-1252');
                }
            }
            return $dado;
        }

        $item = array(
            "id" => (int)$row['id_pk'],
            "nome" => garantirUTF8($row['nome']),
            "data_encontrado" => $row['dataEncontrado'],
            "local_encontrado" => garantirUTF8($row['localizacaoEncontrada']),
            "local_buscar" => garantirUTF8($row['localizacaoBuscar']),
            "tipo" => garantirUTF8($row['tipo']),
            "administrador_fk" => (int)$row['administrador_fk'],
            "status" => $row['status'],
            "data_cadastro" => $row['dataCadastro']
        );

        if (!empty($row['imagem'])) {
            $item['imagem'] = $url_base . $row['imagem'];
        } else {
            $item['imagem'] = null;
        }

        echo json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // DEBUG: Para ver o que está sendo enviado
        // file_put_contents('debug_json.log', print_r($item, true), FILE_APPEND);

    } else {
        echo json_encode(["erro" => "Item não encontrado ou indisponível"]);
    }
} catch (Exception $e) {
    // Log de erro para debug
    error_log("API Error: " . $e->getMessage());
    echo json_encode(["erro" => "Falha ao carregar item"]);
}
