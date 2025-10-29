<?php
//connexion à la première base de données (carre)
try {
    $bdd1 = new PDO('mysql:host=localhost;dbname=carre;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

//connexion à la deuxième base de données (avis)
try {
    $bdd2 = new PDO('mysql:host=localhost;dbname=avis;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

//connexion à la troisième base de données (concert)
try {
    $bdd3 = new PDO('mysql:host=localhost;dbname=concert;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

//récupération des données des colonnes spécifiques de la première base de données
$query1 = $bdd1->query("SELECT nom, prenom, email, tel FROM users");  //sélectionne uniquement les colonnes que l'on a besoin

//récupération des avis de la deuxième base de données
$query2 = $bdd2->query("SELECT prenom, avis FROM avis");//sélectionne uniquement les colonnes que l'on a besoin

//récupération des concerts de la troisième base de données
$query3 = $bdd3->query("SELECT nom, artiste, date_reservation FROM concert1");//sélectionne uniquement les colonnes que l'on a besoin
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carré des jeux ADMIN</title>
    <link rel="stylesheet" href="assets/css/Admin.css">
</head>

<body>
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
<!-- desciptif de la page-->
    <main>
        <section id="page-admin">
            <h2>Bienvenue dans l'interface d'administration</h2>
            <p>Vous êtes connecté en tant qu'administrateur. <br>
            Cette interface vous permet de voir les coordonnées de toutes les personnes qui se sont inscrites sur votre site web.<br> 
            Vous avez également la possibilité, depuis cet espace, de voir et supprimer les avis laissés par vos clients !<br></p>
        </section>
        <br><br><br><br>

        <!-- premier tableau (utilisateur) -->
        <div>
            <?php
            echo "<h2>Tableau des données des utilisateurs</h2>";
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Nom</th>";
            echo "<th>Prénom</th>";
            echo "<th>Email</th>";
            echo "<th>Téléphone</th>";
            echo "</tr>";

            while ($row1 = $query1->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row1['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($row1['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($row1['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row1['tel']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <br><br><br><br><br><br><br><br>

        <!-- deuxième tableau (avis) -->
        <div>
            <?php
            echo "<h2>Tableau des avis</h2>";
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Prénom</th>";
            echo "<th>Avis</th>";
            echo "</tr>";

            while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row2['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($row2['avis']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <br><br><br><br><br><br><br><br>

        <!-- troisième tableau (concerts) -->
        <div>
            <?php
            echo "<h2>Tableau des concerts</h2>";
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Nom</th>";
            echo "<th>Artiste</th>";
            echo "<th>Date</th>";
            echo "</tr>";

            while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row3['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($row3['artiste']) . "</td>";
                echo "<td>" . htmlspecialchars($row3['date_reservation']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>
    </main>

</body>
</html>
