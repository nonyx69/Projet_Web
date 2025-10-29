<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=carre;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// formulaire d'inscription
if (isset($_POST['inscription'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $tel = htmlspecialchars($_POST['tel']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
// verification de chaque question
    if (!empty($nom) && !empty($prenom) && !empty($tel) && !empty($email) && !empty($mdp) && !empty($mdp2)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($mdp == $mdp2) {
                if (strlen($nom) <= 50) {
                    $TestEmail = $bdd->prepare('SELECT id FROM users WHERE email = ?');
                    $TestEmail->execute([$email]);

                    if ($TestEmail->rowCount() < 1) {
                        if (preg_match('/^[0-9]{10}$/', $tel)) {
                            // hachage du mot de passe avant insertion
                            $hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);

                            $InsertUser = $bdd->prepare('INSERT INTO users (nom, prenom, tel, email, mdp) VALUES (?, ?, ?, ?, ?)');
                            $InsertUser->execute([$nom, $prenom, $tel, $email, $hashedMdp]);

                            $returnInscription1 = "Votre compte a bien été créé, veuillez maintenant vous connecter !";
                        } else {
                            $returnInscription = "Le numéro de téléphone entré est invalide !";
                        }
                    } else {
                        $returnInscription = "Votre adresse email est déjà utilisée !";
                    }
                } else {
                    $returnInscription = "Votre nom dépasse 50 caractères !";
                }
            } else {
                $returnInscription = "Les deux mots de passe ne correspondent pas !";
            }
        } else {
            $returnInscription = "L'email est invalide !";
        }
    } else {
        $returnInscription = "Un ou plusieurs champs sont manquants !";
    }
}

// formulaire de connexion
if (isset($_POST['connexion'])) {
    if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
        $email = htmlspecialchars($_POST['email']);
        $mdp = $_POST['mdp'];

        // vérification que l'utilisateur dans la base de données
        $VerifUser = $bdd->prepare('SELECT id, mdp FROM users WHERE email = ?');
        $VerifUser->execute([$email]);

        if ($VerifUser->rowCount() == 1) {
            $UserData = $VerifUser->fetch();

            // vérification du mot de passe haché
            if (password_verify($mdp, $UserData['mdp'])) {
                session_start();
                $_SESSION['login'] = $UserData['id'];
                $returnConnexion = "Vous êtes bien connecté !";
                header("Location: utilisateur.php");
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
    <title>Carré des jeux Inscription</title>
    <link rel="stylesheet" href="assets/css/inscription.css">
</head>

<body background="assets/images/Inscription/Fond 2 Image Inscription.png">

    <header>
        <h1><img src="assets/images/LOGO-sans-fond.png" alt="Logo Le Carré d'As" width="30"> Le Carré des jeux</h1>
    <nav>
        <!-- menu de navigation-->
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="carte.html">Carte</a></li>
                <li><a href="jeux.html">Jeux</a></li>
                <li><a href="concert.html">Concerts</a></li>
                <li><a href="http://localhost/Le%20Carr%C3%A9%20d'As/avis.php">Avis</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="http://localhost/Le%20Carr%C3%A9%20d'As/Inscription.php">Profil</a></li>
                <li><a href="http://localhost/Le%20Carr%C3%A9%20d'As/connexion_admin.php">Admin</a></li>
            </ul>
    </nav>
</header>
<main>
<div class="form-container">
    <!-- formulaire d'inscription -->
    <h2>Je n'est pas encore de compte :</h2>
    <form action="#" method="POST">
        <input type="text" name="nom" placeholder="Votre Nom" required>
        <input type="text" name="prenom" placeholder="Votre Prénom" required>
        <input type="email" name="email" placeholder="Votre adresse email" required>
        <input type="text" name="tel" placeholder="Votre numéro de téléphone" required>
        <input type="password" name="mdp" placeholder="Votre mot de passe" required>
        <input type="password" name="mdp2" placeholder="Confirmer votre mot de passe" required>

        <!-- affichage du message d'inscription en cas d'erreur ou de succès -->
        <center><?php if (isset($returnInscription1)) echo "<p style='color:green;'>$returnInscription1</p>"; ?></center>
        <center><?php if (isset($returnInscription)) echo "<p style='color:red;'>$returnInscription</p>"; ?></center>
        <input type="submit" name="inscription" value="M'inscrire">
    </form>

    <!-- formulaire de connexion -->
     <h2>J'ai déjà un compte :</h2>
    <form action="#" method="POST">
        <input type="email" name="email" placeholder="Votre adresse email" required>
        <input type="password" name="mdp" placeholder="Votre mot de passe" required>

        <!-- affichage du message de connexion en cas d'erreur ou de succès -->
        <center><?php if (isset($returnConnexion)) echo "<p style='color:red;'>$returnConnexion</p>"; ?></center>

        <input type="submit" name="connexion" value="Me connecter">
        
    </form>
</div>
</main>
    
</body>
</html>