<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../Model/pdo.php');

$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$classe_id = (int)$_POST['classe_id'];

try {
    $sql = "INSERT INTO etudiants (nom, prenom, classe_id) 
            VALUES (:nom, :prenom, :classe_id)";

    $stmt = $dbPDO->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':classe_id' => $classe_id
    ]);

    echo "</br>Élève ajouté avec succès !";
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout : " . $e->getMessage();
}

?>
<br>
<a href="../index.php">Retour à l'accueil</a>