<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($annonces as $annonce) : ?>
        <div class="col-md-4 mb-4">

        <a href="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>" class="text-decoration-none">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($annonce['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($annonce['titre']); ?>" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($annonce['titre']); ?></h5>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($annonce['description_courte']); ?></p>
                    <p class="card-text">
                        <small class="text-muted"><?php echo htmlspecialchars($annonce['ville']); ?></small>
                    </p>
                    <!-- Badges couleur selon la catégorie (en cours) -->
                    <p class="card-text">

                        <span class="badge bg-secondary">
                            <?php echo htmlspecialchars($annonce['categorie']); ?>
                        </span>
                    </p>

                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <strong><?php echo number_format($annonce['prix'], 2, ',', ' '); ?> €</strong>
                    <small class="text-muted">par <?php echo htmlspecialchars($annonce['pseudo']); ?></small>
                </div>
            </div>
        </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>