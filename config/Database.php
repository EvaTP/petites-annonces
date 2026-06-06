<?php

class Database {
    // Les propriétés vides — remplies par le constructeur
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private ?PDO $pdo = null;

    // Le constructeur lit les variables du fichier .env
    public function __construct() {
        $this->host     = $_ENV['DB_HOST'];
        $this->dbname   = $_ENV['DB_NAME'];
        $this->user     = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function getConnection(): PDO {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8',
                $this->user,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return $this->pdo;
    }
}