<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4"><i class="bi bi-gear"></i> Administration</h1>

    <!-- Onglets Bootstrap -->
    <ul class="nav nav-tabs mb-4" id="adminTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#annonces">
                <i class="bi bi-megaphone"></i> Annonces (<?php echo count($annonces); ?>)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#membres">
                <i class="bi bi-people"></i> Membres (<?php echo count($membres); ?>)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#categories">
                <i class="bi bi-tags"></i> Catégories (<?php echo count($categories); ?>)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#commentaires">
                <i class="bi bi-chat"></i> Commentaires (<?php echo count($commentaires); ?>)
            </a>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content">

        <!-- Onglet Annonces -->
        <div class="tab-pane fade show active" id="annonces">
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

        <!-- Onglet Membres -->
        <div class="tab-pane fade" id="membres">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membres as $membre) : ?>
                    <tr>
                        <td><?php echo $membre['id_membre']; ?></td>
                        <td><?php echo htmlspecialchars($membre['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($membre['nom']); ?></td>
                        <td><?php echo htmlspecialchars($membre['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($membre['email']); ?></td>
                        <td>
                            <?php if ($membre['statut'] === 'admin') : ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else : ?>
                                <span class="badge bg-secondary">Membre</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($membre['date_enregistrement'])); ?></td>
                        <td>
                            <a href="/petites-annonces/?page=profil-public&id=<?php echo $membre['id_membre']; ?>" class="btn btn-sm btn-info me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/petites-annonces/?page=admin-editer-membre&id=<?php echo $membre['id_membre']; ?>" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/petites-annonces/?page=admin-supprimer-membre&id=<?php echo $membre['id_membre']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce membre ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Onglet Catégories -->
        <div class="tab-pane fade" id="categories">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Mots clés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $categorie) : ?>
                    <tr>
                        <td><?php echo $categorie['id_categorie']; ?></td>
                        <td><?php echo htmlspecialchars($categorie['titre']); ?></td>
                        <td><?php echo htmlspecialchars($categorie['mots_cles'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Onglet Commentaires -->
        <div class="tab-pane fade" id="commentaires">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Membre</th>
                        <th>Annonce</th>
                        <th>Commentaire</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commentaires as $commentaire) : ?>
                    <tr>
                        <td><?php echo $commentaire['id_commentaire']; ?></td>
                        <td><?php echo htmlspecialchars($commentaire['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($commentaire['titre_annonce']); ?></td>
                        <td><?php echo htmlspecialchars($commentaire['commentaire']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($commentaire['date_enregistrement'])); ?></td>
                        <td>
                            <a href="/petites-annonces/?page=admin-supprimer-commentaire&id=<?php echo $commentaire['id_commentaire']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce commentaire ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>