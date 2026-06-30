<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">

        <!-- Colonne filtres -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-funnel"></i> Filtres</h5>

                    <form method="GET" action="/petites-annonces/">
                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="">Toutes les catégories</option>
                                <?php foreach ($categories as $categorie) : ?>
                                    <option value="<?php echo $categorie['id_categorie']; ?>"
                                        <?php echo (isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($categorie['titre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <select class="form-select" id="ville" name="ville">
                                <option value="">Toutes les villes</option>
                                <?php foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville); ?>"
                                        <?php echo (isset($_GET['ville']) && $_GET['ville'] === $ville) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($ville); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="prix_max" class="form-label">
                                Prix maximum : <?php echo htmlspecialchars($_GET['prix_max'] ?? '10000'); ?> €
                            </label>
                            <input type="range" class="form-range" id="prix_max" name="prix_max" min="0" max="10000" step="50" value="<?php echo htmlspecialchars($_GET['prix_max'] ?? '10000'); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-search"></i> Filtrer
                        </button>
                        <a href="/petites-annonces/" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle"></i> Réinitialiser
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne annonces -->
        <div class="col-md-9">
            <p class="text-muted"><?php echo count($annonces); ?> résultat(s)</p>

            <div class="row">
                <?php if (empty($annonces)) : ?>
                    <p class="text-muted">Aucune annonce ne correspond à votre recherche.</p>
                <?php else : ?>
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
                                    <p class="card-text">
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($annonce['categorie']); ?></span>
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
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>