<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/Model/pdo.php');

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
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 1200px;
                margin: 20px auto;
                padding: 0 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 25px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            th,
            td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #4CAF50;
                color: white;
            }

            tr:hover {
                background-color: #f5f5f5;
            }

            form {
                background: #f9f9f9;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
            }

            input[type="text"],
            select {
                width: 100%;
                padding: 8px;
                margin: 8px 0;
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
            }

            button:hover {
                background-color: #45a049;
            }

            a {
                color: #4CAF50;
                text-decoration: none;
                margin-right: 10px;
            }

            a:hover {
                text-decoration: underline;
            }
        </style>
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
                        <td>
                            <a href="Views/modif_etudiant.php?id=<?= $student['id'] ?>">Modifier</a>
                            <a href="Views/suppression_etudiant.php?id=<?= $student['id'] ?>">Supprimer</a>
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
            <button type="submit">Valider</button>
        </form>

    </body>

    </html>

<?php
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>