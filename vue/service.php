<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $employer = getEmployer($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="../public/css/style.css" />
    
</head>
<body>
    <h2>Liste des Employés et Leur Département</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Département</th>
        </tr>

        // Connexion à la base de données
        <?php
        $servername = "localhost";  // Adresse du serveur MySQL
        $username = "root";     // Nom d'utilisateur MySQL
        $password = "";     // Mot de passe MySQL
        $dbname = "gestion_stock_dcli"; // Nom de la base de données

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

        // Requête SQL pour récupérer les données des employés
        $sql = "SELECT nom, prenom FROM employer";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Parcourir chaque ligne de résultat
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nom"] . "</td><td>" . $row["prenom"] . "</td><td>" . $row["Departement"] . "</td></tr>";
            }
        } else {
            echo "0 résultats";
        }

        // Fermer la connexion à la base de données
        $conn->close();
        ?>
        
    </table>
</body>
</html>
