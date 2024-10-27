<?php

namespace Felipe\ApiListatarefa\Models;

use Felipe\ApiListatarefa\DAO\DAO;

class User extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserById($id)
    {
        // Lógica para buscar o usuário no banco de dados
        return ['id' => $id, 'name' => 'Felipe'];
    }

    public function testeConnection(){
        return $this->conexao;
    }
}
