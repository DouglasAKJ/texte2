<?php 
class Pedido{
    private $id;
    private $nome;
    private $usuario;
    private $produtos;
    private $data;
    private $status;


    public function __construct($nome, $usuario, $produtos, $data, $status){
        $this->nome = $nome;
        $this->usuario = $usuario;
        $this->produtos = $produtos;
        $this->data = $data;
        $this->status = $status;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getProdutos(){
        return $this->produtos;
    }

    public function setProdutos($produtos){
        $this->produtos = $produtos;
    }

    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }
}


?>