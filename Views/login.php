<?php
session_start();
require_once('../Model/pdo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $dbPDO->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && $password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: login_page.php');
            exit();
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="../Model/style.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <a href="register.php">Créer un compte</a>
</body>
</html>