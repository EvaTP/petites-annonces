<?php

class Annonce {
    private PDO $pdo;

    // Le constructeur reçoit la connexion PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère toutes les annonces. On joint les tables membre et categorie pour avoir les infos nécessaires
    public function findAll(): array {
        $stmt = $this->pdo->query("
            SELECT a.*, m.pseudo, c.titre AS categorie
            FROM annonce a
            JOIN membre m ON a.membre_id = m.id_membre
            JOIN categorie c ON a.categorie_id = c.id_categorie
            ORDER BY a.date_enregistrement DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}