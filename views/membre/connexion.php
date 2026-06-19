<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-4">Connexion</h1>

            <?php if (!empty($erreurs)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($erreurs as $erreur) : ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/petites-annonces/?page=connexion">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($_POST['pseudo'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp">
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <p class="mt-3 text-center">
                Pas encore membre ? <a href="/petites-annonces/?page=inscription">S'inscrire</a>
            </p>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>