<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petites Annonces</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom py-3">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center fs-2 text-primary" href="/petites-annonces/">
            <img src="/petites-annonces/img/logo50.jpeg" alt="Logo Petites Annonces" height="50" class="me-4 rounded">
        Petites Annonces
        </a>
        <div class="ms-auto">

            <?php if (isset($_SESSION['membre_id'])) : ?>
                <span class="me-3">Bonjour <strong><?php echo htmlspecialchars($_SESSION['pseudo']); ?></strong></span>
                <a href="/petites-annonces/?page=profil" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Mon Profil
                </a>
                <a href="/petites-annonces/?page=deconnexion" class="btn btn-outline-danger ms-2">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            <?php else : ?>
                <a href="/petites-annonces/?page=connexion" class="btn btn-outline-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Connexion
                </a>
                <a href="/petites-annonces/?page=inscription" class="btn btn-primary ms-2">
                    <i class="bi bi-person-plus"></i> Inscription
                </a>
            <?php endif; ?>

        </div>
    </div>
</nav>