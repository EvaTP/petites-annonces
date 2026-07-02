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
            <?php
                $badgeClasses = [
                    'Emploi'     => 'bg-danger',
                    'Vehicule'   => 'bg-primary',
                    'Immobilier' => 'bg-success',
                    'Vacances'   => 'bg-warning text-dark',
                    'Multimedia' => 'bg-info text-dark',
                    'Loisirs'    => 'bg-secondary',
                    'Materiel'   => 'bg-dark',
                    'Services'   => 'bg-primary',
                    'Maison'     => 'bg-success',
                    'Vetements'  => 'bg-danger',
                    'Autres'     => 'bg-secondary',
                ];
                $badgeClass = $badgeClasses[$annonce['categorie']] ?? 'bg-secondary';
                ?>
                <span class="badge <?php echo $badgeClass; ?>">
                    <?php echo htmlspecialchars($annonce['categorie']); ?>
                </span>

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
        
        <!-- Colonne de droite avec le prix et le bouton de contact -->
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

                <!-- Note moyenne du vendeur -->
                <hr>
                
                <div class="text-center mb-2">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <?php if ($noteMoyenne !== null && $i <= round($noteMoyenne)) : ?>
                            <i class="bi bi-star-fill text-warning"></i>
                        <?php else : ?>
                            <i class="bi bi-star text-warning"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($noteMoyenne !== null) : ?>
                        <small class="text-muted d-block"><?php echo $noteMoyenne; ?>/5 basé sur <?php echo count($avis); ?> avis</small>
                    <?php else : ?>
                        <small class="text-muted d-block">Pas encore de note</small>
                    <?php endif; ?>
                </div>

                <!-- Formulaire de notation -->
                <?php if (isset($_SESSION['membre_id']) && $_SESSION['membre_id'] !== $annonce['membre_id']) : ?>
                    <?php if ($dejaNote) : ?>
                        <p class="text-muted text-center small">Vous avez déjà noté ce vendeur.</p>
                    <?php else : ?>
                        <hr>
                        <h6 class="text-center">Noter ce vendeur</h6>

                        <?php if ($succesNote) : ?>
                            <div class="alert alert-success">Note publiée !</div>
                        <?php endif; ?>

                        <?php if (!empty($erreursNote)) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($erreursNote as $erreur) : ?>
                                        <li><?php echo htmlspecialchars($erreur); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>">
                            <!-- Étoiles avec inputs radio cachés -->
                            <div class="text-center mb-2">
                                <div class="star-rating">
                                    <?php for ($i = 5; $i >= 1; $i--) : ?>
                                        <input type="radio" id="star<?php echo $i; ?>" name="note" value="<?php echo $i; ?>" class="star-input">
                                        <label for="star<?php echo $i; ?>" class="star-label">
                                            <i class="bi bi-star-fill"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control form-control-sm" name="avis" rows="2" placeholder="Votre avis (optionnel)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 btn-sm">
                                <i class="bi bi-star"></i> Publier ma note
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php require_once 'views/partials/footer.php'; ?>