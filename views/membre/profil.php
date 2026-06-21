<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">👤 Mon Profil</h1>

            <div class="card shadow-sm">
                <div class="card-body">
                    <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($membre['pseudo']); ?></p>
                    <p><strong>Nom :</strong> <?php echo htmlspecialchars($membre['nom']); ?></p>
                    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($membre['prenom']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($membre['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($membre['telephone'] ?? 'Non renseigné'); ?></p>
                    <p><strong>Civilité :</strong> <?php echo htmlspecialchars($membre['civilite']); ?></p>
                    <p class="mb-0">
                        <strong>Membre depuis :</strong>
                        <?php echo date('d/m/Y', strtotime($membre['date_enregistrement'])); ?>
                    </p>
                </div>
            </div>

            <h2 class="mt-5 mb-3">📣 Mes annonces</h2>
            <?php if (empty($mesAnnonces)) : ?>
                <p class="text-muted">Vous n'avez pas encore déposé d'annonce.</p>
            <?php else : ?>
                <?php foreach ($mesAnnonces as $annonce) : ?>
                    <a href="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>" class="text-decoration-none text-dark">
                        <div class="card mb-3 shadow-sm">
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="/petites-annonces/<?php echo htmlspecialchars($annonce['photo']); ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="<?php echo htmlspecialchars($annonce['titre']); ?>">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($annonce['titre']); ?></h5>
                                        <p class="card-text text-muted"><?php echo htmlspecialchars($annonce['description_courte']); ?></p>
                                        <p class="card-text"><strong><?php echo number_format($annonce['prix'], 2, ',', ' '); ?> €</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>