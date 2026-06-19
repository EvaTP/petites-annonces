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
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>