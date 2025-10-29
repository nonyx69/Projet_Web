<?php
// connexion à la première base de données (réservations)
try {
    $bdd1 = new PDO('mysql:host=localhost;dbname=concert;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die("Erreur de connexion à la base de réservations : " . $e->getMessage());
}

// connexion à la deuxième base de données (users)
try {
    $bdd2 = new PDO('mysql:host=localhost;dbname=carre;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die("Erreur de connexion à la base des utilisateurs : " . $e->getMessage());
}

// initialisation du message
$message = "";

// traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $date_reservation = $_POST['date_reservation'];
    $artiste = $_POST['artiste'];

    // vérification de l'email et du nom dans la base de donné (users)
    $checkUserQuery = "SELECT COUNT(*) FROM users WHERE email = :email AND nom = :nom";
    $stmtCheck = $bdd2->prepare($checkUserQuery);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->bindParam(':nom', $nom);
    $stmtCheck->execute();
    $userExists = $stmtCheck->fetchColumn();

    if ($userExists) {
        // email et nom trouvés, procéder à l'insertion dans la base de donnée
        try {
            $sql = "INSERT INTO concert1 (nom, email, date_reservation, artiste) 
                    VALUES (:nom, :email, :date_reservation, :artiste)";
            $stmt = $bdd1->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':date_reservation', $date_reservation);
            $stmt->bindParam(':artiste', $artiste);

            // exécution de la requête
            $stmt->execute();
            $message = "Réservation effectuée avec succès.";
        } catch (Exception $e) {
            $message = "Erreur lors de la réservation : " . $e->getMessage();
        }
        // erreur nom ou email pas trouver
    } else {
        $message = "Erreur : Le nom ou l'adresse email ne correspondent pas dans notre système.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reservation.css">
    <title>Réservation</title>
</head>
<body background="assets/images/Reservation/Fond.avif">
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
            </ul>
        </nav>
    </header>

    <main>
        <br>
        <!-- desciptif de la page-->
        <section id="reservation">
            <div>
                <p>Bienvenue sur notre page de réservation de concerts !<br><br> Nous sommes ravis de vous accueillir pour des soirées inoubliables, rythmées par la musique live de vos artistes préférés.<br>
Nous tenons à vous remercier chaleureusement pour votre confiance. <br>Votre présence nous motive à organiser des événements toujours plus exceptionnels.
<br>Vous trouverai en bas de cette page un formulaire pour reservé des places de concerts !<br> Si des problémes surviennent contacter nous via la page contact <br>À très bientôt pour une soirée musicale mémorable !<br>
L'équipe du bar 🎶🍹</p>
            </div>
        </section>
        <br><br><br><br><br><br>
    <div class="Canva">
        <!-- images -->
        <div>
            <img src="assets/images/Reservation/5.png" height="225px">
        </div>
        <div>
            <img src="assets/images/Reservation/1.png" height="225px">
        </div>
        <div>
            <img src="assets/images/Reservation/4.png" height="225px">
        </div>
        <div>
            <img src="assets/images/Reservation/2.png" height="225px">
        </div>
        <div>
            <img src="assets/images/Reservation/3.png" height="225px">
        </div>
    </div>
<br><br>
<!-- formulaire de réservation-->
    <center><h2>Formulaire de Réservation</h2></center>
    <form method="POST" action="reservation.php">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="date_reservation">Date de Réservation:</label><br>
        <input type="date" id="date_reservation" name="date_reservation" required><br><br>

        <label for="artiste">Nom de l'Artiste:</label><br>
        <input type="text" id="artiste" name="artiste" required><br><br>

        <?php if (!empty($message)) : ?>
            <p style="color:<?php echo strpos($message, 'succès') ? 'green' : 'red'; ?>; font-weight:bold;">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <center><input type="submit" value="Réserver"></center>
    </form>
    </main>
    <br>
<!-- footer-->
    <footer>
        <p>&copy; 2025 Le Carré des jeux. Tous droits réservés.</p>
    </footer>
</body>
</html>
