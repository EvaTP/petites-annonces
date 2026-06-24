<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">

    <a href="/petites-annonces/" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour vers les annonces
    </a>

    <div class="row">
        <div class="col-md-8">
            <!-- <img src="<?php echo htmlspecialchars($annonce['photo']); ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($annonce['titre']); ?>" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;"> -->
            <img src="<?php echo htmlspecialchars($annonce['photo']); ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($annonce['titre']); ?>" style="width: 100%; max-height: 350px; object-fit: contain; background-color: #f8f9fa;">
            <h1><?php echo htmlspecialchars($annonce['titre']); ?></h1>
            <span class="badge bg-secondary mb-3"><?php echo htmlspecialchars($annonce['categorie']); ?></span>

            <p class="lead"><?php echo htmlspecialchars($annonce['description_longue']); ?></p>

            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">
                    <i class="bi bi-geo-alt"></i>
                    <?php echo htmlspecialchars($annonce['adresse']); ?>,
                    <?php echo htmlspecialchars($annonce['cp']); ?>
                    <?php echo htmlspecialchars($annonce['ville']); ?>,
                    <?php echo htmlspecialchars($annonce['pays']); ?>
                </li>
                <li class="list-group-item">
                    <i class="bi bi-calendar"></i>
                    Publié le <?php echo date('d/m/Y', strtotime($annonce['date_enregistrement'])); ?>
                </li>
            </ul>
            
            <h3 class="mt-5 mb-3">💬 Commentaires</h3>
            <?php if (empty($commentaires)) : ?>
                <p class="text-muted">Aucun commentaire pour cette annonce.</p>
            <?php else : ?>
                <?php foreach ($commentaires as $commentaire) : ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="mb-1"><?php echo htmlspecialchars($commentaire['commentaire']); ?></p>
                            <small class="text-muted">
                                Par <strong><?php echo htmlspecialchars($commentaire['pseudo']); ?></strong>
                                le <?php echo date('d/m/Y à H:i', strtotime($commentaire['date_enregistrement'])); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Formulaire pour poster un commentaire -->
            <div class="mt-4">
                <?php if (isset($_SESSION['membre_id'])) : ?>
                    <h4>Laisser un commentaire</h4>

                    <?php if ($succes) : ?>
                        <div class="alert alert-success">
                            Votre commentaire a bien été publié !
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erreurs)) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($erreurs as $erreur) : ?>
                                    <li><?php echo htmlspecialchars($erreur); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>">
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Votre commentaire</label>
                            <textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Écrivez votre commentaire ici..."><?php echo htmlspecialchars($_POST['commentaire'] ?? ''); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-chat"></i> Publier
                        </button>
                    </form>

                <?php else : ?>
                    <p class="text-muted">
                        <a href="/petites-annonces/?page=connexion">Connectez-vous</a> pour laisser un commentaire.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-success"><?php echo number_format($annonce['prix'], 2, ',', ' '); ?> €</h2>
                    <hr>
                    <p>
                        <i class="bi bi-person-circle"></i>
                        Vendu par <strong><?php echo htmlspecialchars($annonce['pseudo']); ?></strong>
                    </p>
                    <button class="btn btn-success w-100">
                        <i class="bi bi-telephone"></i> Contacter <?php echo htmlspecialchars($annonce['pseudo']); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once 'views/partials/footer.php'; ?>