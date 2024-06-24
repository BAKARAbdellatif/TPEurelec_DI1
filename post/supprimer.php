<?php
if (isset($_GET['id'])) {
    require_once("../connexion.php");
    $id = $_GET['id'];
    $conn = openConnection();
}
