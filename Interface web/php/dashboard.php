<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';
$id_lyceen = $_SESSION['id_lyceen'];
$result = $conn->query("SELECT * FROM lyceen WHERE id_lyceen = $id_lyceen");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Bord</title>
</head>
<body>
    <h1>Bienvenue <?php echo $user['prenom'] . ' ' . $user['nom']; ?></h1>
    <p>État de votre dossier : <?php echo $user['etat_dossier']; ?></p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>