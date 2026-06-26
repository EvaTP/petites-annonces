<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Déposer une annonce</h1>

            <?php if (!empty($erreurs)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($erreurs as $erreur) : ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/petites-annonces/?page=creer-annonce" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre *</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="description_courte" class="form-label">Description courte *</label>
                    <textarea class="form-control" id="description_courte" name="description_courte" rows="2"><?php echo htmlspecialchars($_POST['description_courte'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description_longue" class="form-label">Description longue</label>
                    <textarea class="form-control" id="description_longue" name="description_longue" rows="4"><?php echo htmlspecialchars($_POST['description_longue'] ?? ''); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prix" class="form-label">Prix (€) *</label>
                        <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="<?php echo htmlspecialchars($_POST['prix'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="categorie_id" class="form-label">Catégorie *</label>
                        <select class="form-select" id="categorie_id" name="categorie_id">
                            <option value="0">-- Choisir une catégorie --</option>
                            <?php foreach ($categories as $categorie) : ?>
                                <option value="<?php echo $categorie['id_categorie']; ?>"
                                    <?php echo (isset($_POST['categorie_id']) && $_POST['categorie_id'] == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($categorie['titre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pays" class="form-label">Pays</label>
                    <input type="text" class="form-control" id="pays" name="pays" value="<?php echo htmlspecialchars($_POST['pays'] ?? 'France'); ?>">
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo htmlspecialchars($_POST['adresse'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cp" class="form-label">Code postal</label>
                        <input type="number" class="form-control" id="cp" name="cp" value="<?php echo htmlspecialchars($_POST['cp'] ?? ''); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="ville" class="form-label">Ville *</label>
                    <input type="text" class="form-control" id="ville" name="ville" value="<?php echo htmlspecialchars($_POST['ville'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Formats acceptés : jpg, jpeg, png, webp</small>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Publier l'annonce
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>