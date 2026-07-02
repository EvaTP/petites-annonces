<?php

class Statistique {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Top 5 membres les mieux notés
    public function topMembresMieuxNotes(): array {
        $stmt = $this->pdo->query("
            SELECT m.pseudo, ROUND(AVG(n.note), 1) AS moyenne, COUNT(n.id_note) AS total
            FROM note n
            JOIN membre m ON n.membre_id2 = m.id_membre
            GROUP BY n.membre_id2, m.pseudo
            ORDER BY moyenne DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top 5 membres les plus actifs (le plus d'annonces)
    public function topMembresLusPlusActifs(): array {
        $stmt = $this->pdo->query("
            SELECT m.pseudo, COUNT(a.id_annonce) AS total_annonces
            FROM annonce a
            JOIN membre m ON a.membre_id = m.id_membre
            GROUP BY a.membre_id, m.pseudo
            ORDER BY total_annonces DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top 5 des annonces les plus anciennes
    public function topAnnoncesLesPlusAnciennes(): array {
        $stmt = $this->pdo->query("
            SELECT a.titre, a.date_enregistrement, m.pseudo
            FROM annonce a
            JOIN membre m ON a.membre_id = m.id_membre
            ORDER BY a.date_enregistrement ASC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top 5 des catégories avec le plus d'annonces
    public function topCategories(): array {
        $stmt = $this->pdo->query("
            SELECT c.titre, COUNT(a.id_annonce) AS total_annonces
            FROM annonce a
            JOIN categorie c ON a.categorie_id = c.id_categorie
            GROUP BY a.categorie_id, c.titre
            ORDER BY total_annonces DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}