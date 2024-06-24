<?php
if (isset($_GET['id'])) {
    require_once("../connexion.php");
    $id = $_GET['id'];
    $conn = openConnection();
    $stmt = $conn->prepare("DELETE FROM produits WHERE id LIKE ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    header("Location: index.php");
}
