<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">
                <i class="bi bi-pencil"></i> Éditer le membre
            </h1>

            <a href="/petites-annonces/?page=admin" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Retour au dashboard
            </a>

            <?php if (!empty($erreurs)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($erreurs as $erreur) : ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/petites-annonces/?page=admin-editer-membre&id=<?php echo $membre['id_membre']; ?>">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo *</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($_POST['pseudo'] ?? $membre['pseudo']); ?>">
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? $membre['nom']); ?>">
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom *</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_POST['prenom'] ?? $membre['prenom']); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $membre['email']); ?>">
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($_POST['telephone'] ?? $membre['telephone']); ?>">
                </div>
                <div class="mb-3">
                    <label for="civilite" class="form-label">Civilité</label>
                    <select class="form-select" id="civilite" name="civilite">
                        <option value="Homme" <?php echo ($membre['civilite'] === 'Homme') ? 'selected' : ''; ?>>Homme</option>
                        <option value="Femme" <?php echo ($membre['civilite'] === 'Femme') ? 'selected' : ''; ?>>Femme</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="membre" <?php echo ($membre['statut'] === 'membre') ? 'selected' : ''; ?>>Membre</option>
                        <option value="admin" <?php echo ($membre['statut'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning w-100">
                    <i class="bi bi-check-circle"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>