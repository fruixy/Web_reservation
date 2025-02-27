<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Prise de Rendez-vous</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Rendez-vous en ligne</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="login.html">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.html">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="text-center py-5 bg-primary text-white">
        <div class="container">
            <h1>Bienvenue sur notre plateforme de prise de rendez-vous</h1>
            <p>Réservez facilement vos créneaux en ligne</p>
            <a href="signup.html" class="btn btn-light btn-lg">S'inscrire</a>
            <a href="login.html" class="btn btn-outline-light btn-lg">Se connecter</a>
        </div>
    </header>
    
    <section class="container my-5 content">
        <div class="row text-center">
            <div class="col-md-4">
                <h3>Simple</h3>
                <p>Un processus de réservation rapide et efficace.</p>
            </div>
            <div class="col-md-4">
                <h3>Sécurisé</h3>
                <p>Vos données sont protégées avec les meilleures pratiques.</p>
            </div>
            <div class="col-md-4">
                <h3>Accessible</h3>
                <p>Réservez depuis votre ordinateur ou votre mobile.</p>
            </div>
        </div>
    </section>
    
    <footer class="text-center py-4 bg-primary text-white">
        <p>&copy; 2024 Prise de Rendez-vous. Tous droits réservés.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
