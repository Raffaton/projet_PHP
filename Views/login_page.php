<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../Model/pdo.php');

try {
    $requete_etudiant = $dbPDO->query("
        SELECT e.id, e.nom, e.prenom, c.libelle AS classe 
        FROM etudiants e
        JOIN classes c ON e.classe_id = c.id
    ");
    $students = $requete_etudiant->fetchAll(PDO::FETCH_ASSOC);

    $requete_classe = $dbPDO->query("SELECT libelle FROM classes");
    $classes = $requete_classe->fetchAll(PDO::FETCH_ASSOC);

    $requete_professeur = $dbPDO->query("
        SELECT p.nom, p.prenom, m.lib AS matiere, c.libelle AS classe
        FROM professeurs p
        JOIN matiere m ON p.id_matiere = m.id
        JOIN classes c ON p.id_classe = c.id
    ");
    $professors = $requete_professeur->fetchAll(PDO::FETCH_ASSOC);
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Liste des Étudiants, Classes et Professeurs</title>
        <link rel="stylesheet" href="../Model/style.css">
    </head>

    <body>
        <a href="logout.php">Déconnexion</a>
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
                        <td>
                            <a href="modif_etudiant.php?id=<?= $student['id'] ?>">Modifier</a>
                            <a href="suppression_etudiant.php?id=<?= $student['id'] ?>">Supprimer</a>
                        </td>
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
        <form action="nouvelle_matiere.php" method="POST">
            <div>
                <label for="libelle">Libellé:</label>
                <input type="text" id="libelle" name="libelle" required>
            </div>
            <button type="submit">Valider</button>
            </div>
        </form>

        <h2>Ajout d'un nouvel élève</h2>
        <form action="nouvel_etudiant.php" method="POST">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
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