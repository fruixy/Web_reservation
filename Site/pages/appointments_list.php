<?php
session_start();
require_once '../config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les rendez-vous de l'utilisateur
$stmt = $pdo->prepare("SELECT id, date_rdv, heure_rdv, statut FROM appointments WHERE utilisateur_id = ? ORDER BY date_rdv, heure_rdv");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = securiser($_POST['delete_id']);
    
    // Supprimer le rendez-vous
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND utilisateur_id = ?");
    $stmt->execute([$delete_id, $user_id]);
    
    header("Location: appointments_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous</title>
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
        <h2 class="text-center mb-4">Mes Rendez-vous</h2>
        <table class="table table-bordered bg-white shadow">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucun rendez-vous enregistré.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo date('d-m-Y', strtotime($appointment['date_rdv'])); ?></td>
                            <td><?php echo htmlspecialchars($appointment['heure_rdv']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['statut']); ?></td>
                            <td>
                                <form action="appointments_list.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $appointment['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous annuler ce rendez-vous ?');">Annuler</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center mt-3">
            <a href="appointment.php" class="btn btn-primary">Prendre un nouveau rendez-vous</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
