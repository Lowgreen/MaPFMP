<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = hash('sha256', $_POST['password']);

    $result = $conn->query("SELECT * FROM authentification 
                           WHERE email = '$email' AND mot_de_passe = '$password'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id_auth'];
        $_SESSION['user_type'] = $user['type_utilisateur'];
        $_SESSION['id_lyceen'] = $user['id_lyceen'];

        if ($user['type_utilisateur'] == 'lyceen') {
            header("Location: ..\index.html");
        } else {
            header("Location: bde_dashboard.php");
        }
    } else {
        echo "Identifiants incorrects!";
    }
    
    $conn->close();
}
?>