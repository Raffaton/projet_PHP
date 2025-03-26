<?php
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

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
    }

    form {
        background: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        color: #4CAF50;
    }
</style>