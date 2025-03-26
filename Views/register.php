<?php
session_start();
require_once('../Model/pdo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $stmt = $dbPDO->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        $error = "Cet email est déjà utilisé.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="../Model/style.css">
</head>
<body>
    <h2>Inscription</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
    <a href="login.php">Déjà un compte ?</a>
</body>
</html>