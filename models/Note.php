<?php

class Note {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère la note moyenne d'un membre
    public function getNoteMoyenne(int $membreId): ?float {
        $stmt = $this->pdo->prepare("
            SELECT AVG(note) as moyenne, COUNT(*) as total
            FROM note
            WHERE membre_id2 = :membreId
        ");
        $stmt->bindValue(':membreId', $membreId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0 ? round($result['moyenne'], 1) : null;
    }

    // Récupère tous les avis d'un membre
    public function findAvisByMembreId(int $membreId): array {
        $stmt = $this->pdo->prepare("
            SELECT n.*, m.pseudo
            FROM note n
            JOIN membre m ON n.membre_id1 = m.id_membre
            WHERE n.membre_id2 = :membreId
            ORDER BY n.date_enregistrement DESC
        ");
        $stmt->bindValue(':membreId', $membreId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifie si un membre a déjà noté un autre membre
    public function hasAlreadyNoted(int $membreId1, int $membreId2): bool {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total
            FROM note
            WHERE membre_id1 = :membreId1
            AND membre_id2 = :membreId2
        ");
        $stmt->bindValue(':membreId1', $membreId1, PDO::PARAM_INT);
        $stmt->bindValue(':membreId2', $membreId2, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // Crée une nouvelle note
    public function create(int $membreId1, int $membreId2, int $note, string $avis): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO note (membre_id1, membre_id2, note, avis)
            VALUES (:membreId1, :membreId2, :note, :avis)
        ");
        $stmt->bindValue(':membreId1', $membreId1, PDO::PARAM_INT);
        $stmt->bindValue(':membreId2', $membreId2, PDO::PARAM_INT);
        $stmt->bindValue(':note',      $note,      PDO::PARAM_INT);
        $stmt->bindValue(':avis',      $avis,      PDO::PARAM_STR);

        return $stmt->execute();
    }
}