<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../Model/pdo.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $verif_etudiant = $dbPDO->prepare("SELECT id FROM etudiants WHERE id = :id");
    $verif_etudiant->execute([':id' => $id]);

    if ($verif_etudiant->fetch()) {
        $sup_etudiant = $dbPDO->prepare("DELETE FROM etudiants WHERE id = :id");
        $sup_etudiant->execute([':id' => $id]);

        echo "</br>Suppression de l'étudiant réussie. Redirection...";
        header("Refresh: 2; url=../index.php");
        exit();
    } else {
        die("</br>Étudiant introuvable.");
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
