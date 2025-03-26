<link rel="stylesheet" href="../Model/style.css">

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once('../Model/pdo.php'); 

    $libelle = $_POST['libelle'];

    if (isset($libelle)) {
        try {
            $resultat = $dbPDO->prepare("INSERT INTO matiere (lib) VALUES (:libelle)");
            $resultat->bindParam(':libelle', $libelle);
            
            if ($resultat->execute()) {
                
                echo "</br>La nouvelle matière a été ajoutée avec succès !";
            } else {
                echo "</br>Erreur lors de l'ajout de la matière.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Erreur de base de données : " . $e->getMessage();
        }
    } else {
        $errorMessage = "Le libellé ne peut pas être vide.";
    }

    
?>
</br>
<a href="login_page.php">Retour à l'acceuil</a>