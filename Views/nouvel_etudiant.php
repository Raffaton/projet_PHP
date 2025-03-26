<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../Model/pdo.php');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];

if (isset($nom) && isset($prenom)) {
    try {
        $sql = "INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, 1)";
        $stmt = $dbPDO->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);

        if ($stmt->execute()) {
            echo "</br>L'élève a été ajouté avec succès !";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Tous les champs doivent être remplis.";
}

?>
<br>
<a href="../index.php">Retour à l'accueil</a>