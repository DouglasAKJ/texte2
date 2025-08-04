<?php 
    class Usuario{
        private $id;
        private $email;
        private $nome;
        private $senha;
        private $endereco;
        private $pedidos;
        private $cartoes;

        public function __construct($email, $nome, $senha){
            $this->email = $email;
            $this->nome = $nome;
            $this->senha = $senha;
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setNome($nome){
            return $this->nome = $nome;
        }

        public function getSenha(){
            return $this->senha;
        }

        public function setSenha($senha){
            $this->senha = $senha;
        }

        public function getEndereco(){
            return $this->endereco;
        }

        public function setEndereco($endereco){
            $this->endereco = $endereco;
        }

        public function getPedidos(){
            return $this->pedidos;
        }

        public function setPedidos($pedidos){
            $this->pedidos = $pedidos;
        }

        public function getCartoes(){
            return $this->cartoes;
        }

        public function setCartoes($cartoes){
            $this->cartoes = $cartoes;
        }


    }

?>