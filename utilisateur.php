<?php
// Connexion à la première base de données (carre)
try {
    $bdd1 = new PDO('mysql:host=localhost;dbname=carre;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// Connexion à la deuxième base de données (concert)
try {
    $bdd2 = new PDO('mysql:host=localhost;dbname=concert;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// Récupération des avis de la deuxième base de données
$query2 = $bdd2->query("SELECT date_reservation, artiste FROM concert1 ORDER BY date_reservation ASC");  // Sélectionne les colonnes des avis
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carré des jeux USER</title>
    <link rel="stylesheet" href="assets/css/user.css">
</head>

<body background="assets/images/Utilisateur/Fond.jpg">
    <header>

        <h1><img src="assets/images/LOGO-sans-fond.png" alt="Logo Le Carré d'As" width="30"> Le Carré des jeux</h1>
        <nav>
            <!-- menu de navigation-->
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="carte.html">Carte</a></li>
                <li><a href="jeux.html">Jeux</a></li>
                <li><a href="concert.html">Concerts</a></li>
                <li><a href="http://localhost/Le%20Carré%20d'As/avis.php">Avis</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="http://localhost/Le%20Carré%20d'As/Inscription.php">Profil</a></li>
            </ul>
        </nav>
    </header>
    <br>
    <main>
        <!-- desciptif de la page-->
        <section id="user">
            <h2>Bienvenue sur votre page d'historique de réservation de concert !</h2>
            <div>
                <p>Sur cette page tu pourras retrouver l'hisorique de tout les concert que tu a vu au sein du Carré D'As.<br>Tu y retrouve inscrit dans le tableau ci-dessous la date du concert ainsi que le nom de l'artiste, ce qui on l'espère te redonnera la hype de venir refaire un tour, et cette fois ci avec des amis ou de la famille qui sait ?<br>Merci encore de participé a ces concerts et a trés vite on l'espère !</p>
            </div>
        </section>
        <br><br><br><br>
        <table border="1" cellpadding="5" cellspacing="0">
            <!-- Deuxième tableau des avis -->
            <?php
            echo "<table border='1'>";
            echo "<tr>";
            
            // Afficher les en-têtes de colonnes spécifiées
            echo "<th>Date</th>";
            echo "<th>Artiste</th>";
            echo "</tr>";

            // Affichage des données ligne par ligne
            while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row2['date_reservation']) . "</td>";
                echo "<td>" . htmlspecialchars($row2['artiste']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>  
        </table>
    </main>
</body>

</html>
