<?php

namespace Felipe\ApiListatarefa\DAO;

use \PDO;
use \PDOException;

abstract class DAO
{
    protected $conexao;

    public function __construct()
    {

        $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";

        try {
            $this->conexao = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
            exit;
        }
    }
}
