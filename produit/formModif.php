<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
session_start();
include_once '../connexion.php';
$conn = openConnection();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM produits WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<?php //if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) { 
?>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Modifier un produit</a>
        </div>
    </nav>
    <div class="container-fluid p-4">
        <form method="POST" action="modifier.php">
            <input type="hidden" name="id" id="id" value="<?php echo $produit['id']; ?>">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" value="<?php echo $produit['titre']; ?>" id="titre" name="titre">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">description</label>
                <textarea class="form-control" name="description" id="description" cols="10" rows="3"><?php echo $produit['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">prix</label>
                <input type="number" min="0" step="0.01" value="<?php echo $produit['prix']; ?>" class="form-control" name="prix" id="prix">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php //} 
?>

</html>