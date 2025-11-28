<?php 

class item_perdido{

private static $itens = [];


public function __construct() {

}

public function criar($nome, $data, $local, $categoria, $foto){
    $novo_item = [
            'nome'      => $nome,
            'data'      => $data,
            'local'     => $local,
            'categoria' => $categoria,
            'foto'      => $foto
    ];

    self::$itens[] = $novo_item;

    return $novo_item;
}

    public function listar(){
        return self::$itens;
    }
}

?>