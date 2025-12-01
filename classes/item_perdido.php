<?php
class ItemPerdido
{
    public $id_pk;
    public $nome;
    public $dataEncontrado;
    public $localizacaoEncontrada;
    public $localizacaoBuscar;
    public $tipo;
    public $imagem;
    public $administrador_fk;
    public $status;
    public $dataCadastro;

    public function __construct($nome, $dataEncontrado, $localizacaoEncontrada, $localizacaoBuscar, $tipo, $imagem = null, $administrador_fk = null, $status = 'disponivel')
    {
        $this->nome = $nome;
        $this->dataEncontrado = $dataEncontrado;
        $this->localizacaoEncontrada = $localizacaoEncontrada;
        $this->localizacaoBuscar = $localizacaoBuscar;
        $this->tipo = $tipo;
        $this->imagem = $imagem;
        $this->administrador_fk = $administrador_fk;
        $this->status = $status;
    }

    public function getIdPk()
    {
        return $this->id_pk;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getDataEncontrado()
    {
        return $this->dataEncontrado;
    }
    public function getLocalizacaoEncontrada()
    {
        return $this->localizacaoEncontrada;
    }
    public function getLocalizacaoBuscar()
    {
        return $this->localizacaoBuscar;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getImagem()
    {
        return $this->imagem;
    }
    public function getAdministradorFk()
    {
        return $this->administrador_fk;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setDataEncontrado($dataEncontrado)
    {
        $this->dataEncontrado = $dataEncontrado;
    }
    public function setLocalizacaoEncontrada($localizacaoEncontrada)
    {
        $this->localizacaoEncontrada = $localizacaoEncontrada;
    }
    public function setLocalizacaoBuscar($localizacaoBuscar)
    {
        $this->localizacaoBuscar = $localizacaoBuscar;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }
    public function setAdministradorFk($administrador_fk)
    {
        $this->administrador_fk = $administrador_fk;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
?>