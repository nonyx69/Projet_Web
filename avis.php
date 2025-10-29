<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=avis;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// traitement du formulaire d'avis
if (isset($_POST['submit'])) {
    // récupérer les données du formulaire
    $prenom = htmlspecialchars($_POST['prenom']);
    $avis = htmlspecialchars($_POST['avis']);

    // insertion dans la base de données
    $query = $bdd->prepare("INSERT INTO avis (prenom, avis) VALUES (?, ?)");
    $query->execute([$prenom, $avis]);
}

// récupérer les avis de la base de données
$query2 = $bdd->query("SELECT prenom, avis FROM avis ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis - Le Carré des jeux</title>
    <link rel="stylesheet" href="assets/css/avis.css">
</head>

<body background="assets/images/Fond Avis.png">
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

    <br><br><br><br>
    <div class="container">
        <h1>Avis sur notre bar</h1>

        <!-- afficher les avis -->
        <div id="avis-list">
            <h2>Avis des clients</h2>
            <?php
            //affichage des avis (depuis la base de données)
            while ($row = $query2->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='avis'>";
                echo "<p><strong>" . htmlspecialchars($row['prenom']) . ":</strong> " . htmlspecialchars($row['avis']) . "</p>";
                echo "</div><br>";
            }
            ?>
        </div>

        <!-- formulaire pour laisser un avis -->
        <h2>Laisser un avis</h2>
        <form method="POST" action="">
            <label for="prenom">Votre prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="avis">Votre avis :</label>
            <textarea id="avis" name="avis" rows="4" required></textarea>

            <button type="submit" name="submit">Publier</button>
        </form>
    </div>


</body><br><br>
</html>
