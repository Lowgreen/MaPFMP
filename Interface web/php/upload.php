<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pfmp';
$port = 3307;

$response = ['success' => false];

try {
    // Connexion
    $conn = new mysqli($host, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        throw new Exception("Échec de connexion : " . $conn->connect_error);
    }

    // Vérification méthode et fichier
    if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES['file'])) {
        throw new Exception('Requête invalide');
    }

    // Récupération données
    $file = $_FILES['file'];
    $id_lyceen = 1;
    $id_type = 1;

    // Validation des entrées
    if (!$id_lyceen || !$id_type) {
        throw new Exception('Données manquantes');
    }

    // Vérification erreur upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Erreur de téléchargement : ' . $file['error']);
    }

    // Vérification type MIME
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

    // Taille maximale
    $maxSize = 10 * 1024 * 1024; // 10 Mo
    if ($file['size'] > $maxSize) {
        throw new Exception('Fichier trop volumineux (max 10 Mo)');
    }

    // Création dossier
    $uploadDir = 'uploads/' . date('Y/m/');
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        throw new Exception('Impossible de créer le dossier');
    }

    // Génération nom unique
    $extension = $allowedTypes[$mime];
    $filename = uniqid('doc_') . '.' . $extension;
    $destination = $uploadDir . $filename;

    // Déplacement fichier
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception('Échec de l\'enregistrement du fichier');
    }

    // Insertion en BDD
	$stmt = $conn->prepare("INSERT INTO document (id_lyceen, nom, taille, id_type, date_publication) VALUES (?, ?, ?, ?, NOW())");
	$stmt->bind_param("issi", $id_lyceen, $filename, $file['size'], $id_type);
    
    if (!$stmt->execute()) {
        throw new Exception('Erreur SQL : ' . $stmt->error);
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