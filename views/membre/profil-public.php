<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">

        <!-- Colonne gauche : infos du membre -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #adb5bd;"></i>
                    <h3 class="mt-2"><?php echo htmlspecialchars($membre['pseudo']); ?></h3>
                    <p class="text-muted">Membre depuis <?php echo date('d/m/Y', strtotime($membre['date_enregistrement'])); ?></p>

                    <!-- Note moyenne -->
                    <div class="my-2">
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

                    <!-- Téléphone visible uniquement si connecté -->
                    <?php if (isset($_SESSION['membre_id'])) : ?>
                        <hr>
                        <p class="mb-0">
                            <i class="bi bi-telephone"></i>
                            <?php echo htmlspecialchars($membre['telephone'] ?? 'Non renseigné'); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Infos supplémentaires si admin -->
                    <?php if (isset($_SESSION['statut']) && $_SESSION['statut'] === 'admin') : ?>
                        <hr>
                        <table class="table table-sm text-start">
                            <tr>
                                <th>Nom</th>
                                <td><?php echo htmlspecialchars($membre['nom']); ?></td>
                            </tr>
                            <tr>
                                <th>Prénom</th>
                                <td><?php echo htmlspecialchars($membre['prenom']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($membre['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                    <?php if ($membre['statut'] === 'admin') : ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Membre</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Avis reçus -->
            <?php if (!empty($avis)) : ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Avis reçus</h5>
                        <?php foreach ($avis as $unAvis) : ?>
                            <div class="mb-3 border-bottom pb-2">
                                <div>
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <?php if ($i <= $unAvis['note']) : ?>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        <?php else : ?>
                                            <i class="bi bi-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="mb-1 small"><?php echo htmlspecialchars($unAvis['avis']); ?></p>
                                <small class="text-muted">
                                    Par <strong><?php echo htmlspecialchars($unAvis['pseudo']); ?></strong>
                                    le <?php echo date('d/m/Y', strtotime($unAvis['date_enregistrement'])); ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Colonne droite : annonces du membre -->
        <div class="col-md-8">
            <h4 class="mb-3">Annonces de <?php echo htmlspecialchars($membre['pseudo']); ?></h4>

            <?php if (empty($mesAnnonces)) : ?>
                <p class="text-muted">Ce membre n'a pas encore déposé d'annonce.</p>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($mesAnnonces as $annonce) : ?>
                        <div class="col-md-6 mb-4">
                            <a href="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>" class="text-decoration-none">
                                <div class="card h-100 shadow-sm">
                                    <img src="<?php echo htmlspecialchars($annonce['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($annonce['titre']); ?>" style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($annonce['titre']); ?></h5>
                                        <p class="card-text text-muted"><?php echo htmlspecialchars($annonce['description_courte']); ?></p>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($annonce['categorie']); ?></span>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <strong><?php echo number_format($annonce['prix'], 2, ',', ' '); ?> €</strong>
                                        <small class="text-muted"><?php echo htmlspecialchars($annonce['ville']); ?></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>