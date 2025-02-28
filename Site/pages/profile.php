<?php
session_start();
require_once '../config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success = "";
$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT nom, prenom, email, telephone, date_naissance, adresse FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_account'])) {
        // Supprimer le compte utilisateur
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        $nom = securiser($_POST['nom']);
        $prenom = securiser($_POST['prenom']);
        $email = securiser($_POST['email']);
        $telephone = securiser($_POST['telephone']);
        $date_naissance = securiser($_POST['date_naissance']);
        $adresse = securiser($_POST['adresse']);
        
        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if ($stmt->fetch()) {
            $errors[] = "Cet email est déjà utilisé par un autre compte.";
        }
        
        if (empty($errors)) {
            // Mettre à jour les informations
            $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, telephone = ?, date_naissance = ?, adresse = ? WHERE id = ?");
            $stmt->execute([$nom, $prenom, $email, $telephone, $date_naissance, $adresse, $user_id]);
            
            $success = "Vos informations ont été mises à jour avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand text-white">Réservation médicale</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="appointment.php">Prendre Rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="appointments_list.php">Mes Rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="profile.php">Mon Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">Mon Profil</h2>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <p class="mb-0">- <?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <p><?php echo $success; ?></p>
                        </div>
                    <?php endif; ?>
                    <form action="profile.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($user['telephone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" name="date_naissance" class="form-control" value="<?php echo htmlspecialchars($user['date_naissance']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="adresse" class="form-control" value="<?php echo htmlspecialchars($user['adresse']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                    </form>
                    <form action="profile.php" method="POST" class="mt-3">
                        <input type="hidden" name="delete_account" value="1">
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">Supprimer mon compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>