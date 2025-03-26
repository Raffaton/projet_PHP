<link rel="stylesheet" href="../Model/style.css">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../Model/pdo.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $resultat = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = :id");
    $resultat->execute([':id' => $id]);
    $etudiant = $resultat->fetch();

    if (!$etudiant) {
        die("Étudiant introuvable.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);

        $modification = $dbPDO->prepare("
            UPDATE etudiants 
            SET nom = :nom, prenom = :prenom 
            WHERE id = :id
        ");
        $modification->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':id' => $id
        ]);

        header('Location: login_page.php');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<form method="POST">
    <input type="text" name="nom" value="<?= $etudiant['nom'] ?>" required>
    <input type="text" name="prenom" value="<?= $etudiant['prenom'] ?>" required>
    <button type="submit">Valider</button>
</form>