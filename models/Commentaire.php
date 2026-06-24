<?php

class Commentaire {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère tous les commentaires d'une annonce, avec le pseudo de l'auteur
    public function findByAnnonceId(int $annonceId): array {
        $stmt = $this->pdo->prepare("
            SELECT c.*, m.pseudo
            FROM commentaire c
            JOIN membre m ON c.membre_id = m.id_membre
            WHERE c.annonce_id = :annonceId
            ORDER BY c.date_enregistrement DESC
        ");
        $stmt->bindValue(':annonceId', $annonceId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajoute un nouveau commentaire
    public function create(int $membreId, int $annonceId, string $commentaire): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO commentaire (membre_id, annonce_id, commentaire)
            VALUES (:membreId, :annonceId, :commentaire)
        ");
        $stmt->bindValue(':membreId',    $membreId,    PDO::PARAM_INT);
        $stmt->bindValue(':annonceId',   $annonceId,   PDO::PARAM_INT);
        $stmt->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
