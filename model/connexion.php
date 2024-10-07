



<?php
/*session_start();

$nom_serveur = "localhost";
$nom_base_de_donne = "gestion_stock_dcli";
$utilisateur = "root";
$motpass = "";

try {
    $connexion = new PDO("mysql:host=$nom_serveur;dbname=$nom_base_de_donne", $utilisateur, $motpass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connexion;
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
*/


session_start();

$nom_serveur = "localhost";
$nom_base_de_donne = "gestion_stock_dcli";
$utilisateur = "root";
$motpass = "";

try {
    // Crée une instance de PDO pour la connexion à la base de données
    $connexion = new PDO("mysql:host=$nom_serveur;dbname=$nom_base_de_donne", $utilisateur, $motpass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Définir la variable globale
    $GLOBALS['connexion'] = $connexion;
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>


