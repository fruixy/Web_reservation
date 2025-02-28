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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_rdv'])) {
    $date_rdv = securiser($_POST['date_rdv']);
    $heure_rdv = securiser($_POST['heure_rdv']);

    // Vérifier si le créneau est déjà pris
    $stmt = $pdo->prepare("SELECT id FROM appointments WHERE date_rdv = ? AND heure_rdv = ?");
    $stmt->execute([$date_rdv, $heure_rdv]);
    
    if ($stmt->fetch()) {
        $errors[] = "Ce créneau est déjà réservé. Veuillez choisir un autre horaire.";
    }

    if (empty($errors)) {
        // Insérer le rendez-vous en base
        $stmt = $pdo->prepare("INSERT INTO appointments (utilisateur_id, date_rdv, heure_rdv, statut) VALUES (?, ?, ?, 'confirmé')");
        $stmt->execute([$user_id, $date_rdv, $heure_rdv]);
        
        $success = "Votre rendez-vous a été réservé avec succès !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre un Rendez-vous</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
</head>
<body class="bg-light">
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
    <div class="mt-5 w-50 mx-auto">
        <h2 class="text-center mb-4">Prendre un Rendez-vous</h2>
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
        
        <form action="appointment.php" method="POST" class="text-center">
            <div class="mb-3">
                <label for="date_rdv" class="form-label">Sélectionnez une date :</label>
                <input type="date" name="date_rdv" id="date_rdv" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="heure_rdv" class="form-label">Sélectionnez une heure :</label>
                <select name="heure_rdv" id="heure_rdv" class="form-control" required>
                    <option value="08:00">08:00</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00">09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Réserver</button>
        </form>
    </div>
  
    <div class="mt-5 w-50 mx-auto">
        <h4 class="text-center">Nous Contacter</h4>
        <form action="appointment.php" method="POST">
            <div class="mb-2">
                <input type="text" name="nom_contact" class="form-control" placeholder="Nom" required>
            </div>
            <div class="mb-2">
                <input type="email" name="email_contact" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-2">
                <textarea name="message" class="form-control" rows="2" placeholder="Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-secondary w-100">Envoyer</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

