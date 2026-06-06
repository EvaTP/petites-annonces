<?php

class Membre {
    private int $id;
    private string $pseudo;
    private string $email;
    private string $mdp;
    private string $nom;
    private string $prenom;
    private string $telephone;
    private string $civilite;
    private string $statut;
    private string $dateEnregistrement;

    public function __construct(
        string $pseudo,
        string $email,
        string $mdp,
        string $nom,
        string $prenom,
        string $telephone,
        string $civilite
    ) {
        $this->pseudo    = $pseudo;
        $this->email     = $email;
        $this->mdp       = $mdp;
        $this->nom       = $nom;
        $this->prenom    = $prenom;
        $this->telephone = $telephone;
        $this->civilite  = $civilite;
    }

    // Getters — pour lire les propriétés depuis l'extérieur
    public function getId(): int { return $this->id; }
    public function getPseudo(): string { return $this->pseudo; }
    public function getEmail(): string { return $this->email; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getTelephone(): string { return $this->telephone; }
    public function getCivilite(): string { return $this->civilite; }
    public function getStatut(): string { return $this->statut; }
}
