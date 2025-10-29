<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=admin;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}


// formulaire de connexion
if (isset($_POST['connexion'])) {
    if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
        $email = htmlspecialchars($_POST['email']);
        $mdp = $_POST['mdp'];

        // vérification que l'utilisateur soit dans notre base de données
        $VerifUser = $bdd->prepare('SELECT id, mdp FROM admin1 WHERE email = ?');
        $VerifUser->execute([$email]);

        if ($VerifUser->rowCount() == 1) {
            $UserData = $VerifUser->fetch();

            // vérification du mot de passe haché
            if (password_verify($mdp, $UserData['mdp'])) {
                session_start();
                $_SESSION['login'] = $UserData['id'];
                $returnConnexion = "Vous êtes bien connecté !";
                header("Location: page-admin.php");
                exit();
            } else {
                $returnConnexion = "Les identifiants sont invalides !";
            }
        } else {
            $returnConnexion = "Les identifiants sont invalides !";
        }
    } else {
        $returnConnexion = "Un ou plusieurs champs sont manquants !";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carré des jeux connexion-ADMIN</title>
    <link rel="stylesheet" href="assets/css/admin1.css">
</head>

<body background="assets/images/Connexion_Admin/Fond.">
<header>
    
    <h1><img src="assets/images/LOGO-sans-fond.png" alt="Logo Le Carré d'As" width="30"> Le Carré des jeux</h1>
    <nav>
        <!-- menu de navigation -->
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="carte.html">Carte</a></li>
                <li><a href="jeux.html">Jeux</a></li>
                <li><a href="concert.html">Concerts</a></li>
                <li><a href="http://localhost/Le%20Carr%C3%A9%20d'As/avis.php">Avis</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="http://localhost/Le%20Carr%C3%A9%20d'As/Inscription.php">Profil</a></li>
            </ul>
    </nav>
</header>
<main>
<div class="form-container">
    <!-- formulaire de connexion -->
    <form action="#" method="POST">
        <input type="email" name="email" placeholder="Votre adresse email" required>
        <input type="password" name="mdp" placeholder="Votre mot de passe" required>

        <!-- affichage du message en cas d'erreur -->
        <center><?php if (isset($returnConnexion)) echo "<p style='color:red;'>$returnConnexion</p>"; ?></center>

        <input type="submit" name="connexion" value="Me connecter en tant qu'Admin">
    </form>

</div>
</main>

</body>
</html>
