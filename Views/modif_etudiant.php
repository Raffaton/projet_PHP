<?php
require_once('../Model/pdo.php');

$id = isset($_GET['id']);

try {
    $resultat = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = :id");
    $resultat->execute([':id' => $id]);
    $etudiant = $resultat->fetch();

    if (!$etudiant) {
        die("Étudiant introuvable.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        
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
        
        header('Location: ../index.php');
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