<?php

class Cliente {

    private $id;
    private $nome;
    private $telefone;
    private $login;
    private $senha;

    public function __construct($nome, $telefone, $login, $senha) {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->login = $login;
        $this->senha = $senha;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }
}

?>