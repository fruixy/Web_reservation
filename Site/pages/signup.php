<?php
require_once '../config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = securiser($_POST['nom']);
    $prenom = securiser($_POST['prenom']);
    $email = securiser($_POST['email']);
    $telephone = securiser($_POST['telephone']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $date_naissance = securiser($_POST['date_naissance']);
    $adresse = securiser($_POST['adresse']);
    
    // Validation des champs
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    if (strlen($telephone) < 10 || !ctype_digit($telephone)) {
        $errors[] = "Le numéro de téléphone doit contenir au moins 10 chiffres et ne contenir que des chiffres.";
    }
    if (strlen($mot_de_passe) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if (empty($date_naissance)) {
        $errors[] = "La date de naissance est requise.";
    }
    if (empty($adresse)) {
        $errors[] = "L'adresse est requise.";
    }
    
    // Vérifier si l'email est déjà utilisé
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = "Cet email est déjà utilisé.";
    }
    
    if (empty($errors)) {
        // Hachage du mot de passe
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insérer l'utilisateur en base
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, telephone, mot_de_passe, date_naissance, adresse) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $telephone, $hashed_password, $date_naissance, $adresse]);

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">Inscription</h2>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <p class="mb-0">- <?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <form action="signup.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="telephone" class="form-control" placeholder="Téléphone" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" name="date_naissance" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>