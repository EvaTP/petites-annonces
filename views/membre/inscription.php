<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Inscription</h1>

            <?php if (!empty($erreurs)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($erreurs as $erreur) : ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/petites-annonces/?page=inscription">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo *</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($_POST['pseudo'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom *</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe *</label>
                    <input type="password" class="form-control" id="mdp" name="mdp">
                </div>
                <div class="mb-3">
                    <label for="civilite" class="form-label">Civilité *</label>
                    <select class="form-select" id="civilite" name="civilite">
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>

            <p class="mt-3 text-center">
                Déjà membre ? <a href="/petites-annonces/?page=connexion">Se connecter</a>
            </p>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>