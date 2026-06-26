<?php

class Categorie {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère toutes les catégories
    public function findAll(): array {
        $stmt = $this->pdo->query("
            SELECT * FROM categorie ORDER BY titre ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}