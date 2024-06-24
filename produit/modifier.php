
<?php
session_start();
include_once '../connexion.php';
$conn = openConnection();
$titre = $_POST['titre'];
$description = $_POST['description'];
$prix = $_POST['prix'];

if ($titre && ($prix && is_numeric($prix))) {
    include_once 'connexion.php';
    $conn = openConnection();
    $sql = "INSERT INTO produits (titre, description, prix) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $titre);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $prix);
    $stmt->execute();
    $conn = null;
    header("Location: index.php");
}
