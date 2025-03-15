<?php
$host = 'localhost'; // Serveur MySQL (ou une IP si ce n'est pas local)
$username = 'root';  // Nom d'utilisateur MySQL (par défaut : root)
$password = '';      // Mot de passe (par défaut : vide)
$dbname = 'pfmp';    // Nom de ta base de données
$port = 3307;        // Port MySQL (vérifie sur phpMyAdmin si ce n'est pas 3306)

$conn = mysqli_connect($host, $username, $password, $dbname, $port);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>
