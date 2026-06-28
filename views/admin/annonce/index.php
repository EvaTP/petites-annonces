<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">
        <i class="bi bi-gear"></i> Administration — Gestion des annonces
    </h1>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Prix</th>
                <th>Ville</th>
                <th>Catégorie</th>
                <th>Membre</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($annonces as $annonce) : ?>
            <tr>
                <td><?php echo $annonce['id_annonce']; ?></td>
                <td><?php echo htmlspecialchars($annonce['titre']); ?></td>
                <td><?php echo number_format($annonce['prix'], 2, ',', ' '); ?> €</td>
                <td><?php echo htmlspecialchars($annonce['ville']); ?></td>
                <td><?php echo htmlspecialchars($annonce['categorie']); ?></td>
                <td><?php echo htmlspecialchars($annonce['pseudo']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($annonce['date_enregistrement'])); ?></td>
                <td>
                    <a href="/petites-annonces/?page=annonce&id=<?php echo $annonce['id_annonce']; ?>" class="btn btn-sm btn-info me-1">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/petites-annonces/?page=admin-supprimer-annonce&id=<?php echo $annonce['id_annonce']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette annonce ?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/partials/footer.php'; ?>
