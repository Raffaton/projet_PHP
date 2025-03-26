<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/Model/pdo.php');

try {
    $studentsQuery = $dbPDO->query("
        SELECT e.nom, e.prenom, c.libelle AS classe 
        FROM etudiants e
        JOIN classes c ON e.classe_id = c.id
    ");
    $students = $studentsQuery->fetchAll(PDO::FETCH_ASSOC);

    $classesQuery = $dbPDO->query("SELECT libelle FROM classes");
    $classes = $classesQuery->fetchAll(PDO::FETCH_ASSOC);

    $professorsQuery = $dbPDO->query("
        SELECT p.nom, p.prenom, m.lib AS matiere, c.libelle AS classe
        FROM professeurs p
        JOIN matiere m ON p.id_matiere = m.id
        JOIN classes c ON p.id_classe = c.id
    ");
    $professors = $professorsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants, Classes et Professeurs</title>
</head>
<body>
    <h2>Liste des Étudiants</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Classe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['nom'] ?></td>
                    <td><?= $student['prenom'] ?></td>
                    <td><?= $student['classe'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Liste des Classes</h2>
    <table>
        <thead>
            <tr>
                <th>Nom de la Classe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
                <tr>
                    <td><?= $class['libelle'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Liste des Professeurs</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Matière</th>
                <th>Classe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professors as $professor): ?>
                <tr>
                    <td><?= $professor['nom'] ?></td>
                    <td><?= $professor['prenom'] ?></td>
                    <td><?= $professor['matiere'] ?></td>
                    <td><?= $professor['classe'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ajout de matiere</h2>
    <form action="Views/nouvelle_matiere.php" method="POST">
        <div>
            <label for="libelle">Libellé:</label>
            <input type="text" id="libelle" name="libelle" required>
        </div>
            <button type="submit">Valider</button>
        </div>
    </form>
    
    <h2>Ajout d'un nouvel élève</h2>
    <form action="Views/nouvel_etudiant.php" method="POST">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="classe">Classe :</label>
            <select id="classe" name="classe_id" required>
                <?php
                $classes = $dbPDO->query("SELECT id, libelle FROM classes");
                foreach ($classes as $classe) {
                    echo '<option value="' . $classe['id'] . '">' . $classe['libelle'] . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit">Valider</button>
    </form>

</body>
</html>

<?php
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>