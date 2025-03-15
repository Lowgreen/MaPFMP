<?php
// Ajouter le rapport d'erreurs en haut
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Vérifier que ce chemin est correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier que la connexion existe
    if (!$conn) {
        die("Erreur de connexion à la base de données: " . mysqli_connect_error());
    }

    // Récupération des données avec sécurité
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // On hash après
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);

    // Vérifier l'email
    $check = $conn->query("SELECT email FROM authentification WHERE email = '$email'");
    
    if ($check->num_rows > 0) {
        die("Cet email est déjà utilisé.");
    }

    // Insertion dans lyceen
    $insertLyceen = $conn->query("INSERT INTO lyceen (nom, prenom) VALUES ('$nom', '$prenom')");
    
    if ($insertLyceen) {
        $id_lyceen = $conn->insert_id;
        $hashed_password = hash('sha256', $password);
        
        // Insertion dans authentification
        $insertAuth = $conn->query("INSERT INTO authentification 
                                  (email, mot_de_passe, type_utilisateur, id_lyceen) 
                                  VALUES ('$email', '$hashed_password', 'lyceen', $id_lyceen)");
        
        if ($insertAuth) {
            header("Location: ../login.html?inscription=success");
            exit();
        } else {
            echo "Erreur d'authentification: " . $conn->error;
        }
    } else {
        echo "Erreur lyceen: " . $conn->error;
    }
    
    $conn->close();
}
?>