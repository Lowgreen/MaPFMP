<?php
header('Content-Type: application/json');

// Configuration de la base de données
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pfmp';
$port = 3307; 

$response = ['success' => false];

try {
    // Connexion MySQL
    $conn = new mysqli($host, $username, $password, $dbname, $port);
    
    if ($conn->connect_error) {
        throw new Exception("Échec de la connexion: " . $conn->connect_error);
    }

    // Vérification de la méthode et présence du fichier
    if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES['fichier'])) {
        throw new Exception('Requête invalide');
    }

    $file = $_FILES['fichier'];

    // Validation du fichier
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Erreur de téléchargement: ' . $file['error']);
    }

    // Vérification du type MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    
    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'application/pdf' => 'pdf'
    ];

    if (!array_key_exists($mime, $allowedTypes)) {
        throw new Exception('Type de fichier non autorisé');
    }

    // Validation de la taille
    $maxSize = 10 * 1024 * 1024; // 10 Mo
    if ($file['size'] > $maxSize) {
        throw new Exception('Fichier trop volumineux (max 10 Mo)');
    }

    // Structure de dossiers
    $uploadDir = 'uploads/' . date('Y/m/');
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        throw new Exception('Échec de création du dossier');
    }

    // Génération du nom unique
    $extension = $allowedTypes[$mime];
    $filename = uniqid('doc_') . '.' . $extension;
    $destination = $uploadDir . $filename;

    // Déplacement du fichier
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception('Échec de l\'enregistrement du fichier');
    }

    // Enregistrement en base de données
    $stmt = $conn->prepare("INSERT INTO document (id_lyceen, nom, taille, id_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", 
        $_POST['id_lyceen'], // À récupérer depuis la session
        $filename,
        $file['size'],
        $_POST['id_type'] // À adapter selon votre logique
    );
    
    if (!$stmt->execute()) {
        throw new Exception('Erreur d\'enregistrement en base: ' . $stmt->error);
    }

    $response = [
        'success' => true,
        'message' => 'Fichier téléchargé avec succès',
        'path' => $destination
    ];

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {
    if (isset($conn)) $conn->close();
}

echo json_encode($response);
?>