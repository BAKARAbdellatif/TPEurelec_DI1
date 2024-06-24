<?php
session_start();
require_once("../connexion.php");
$conn = openConnection();
$stmt = $conn->prepare("SELECT * FROM produits");
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<script>
    function supprimer(id) {
        if (confirm("Etes-vous sure de vouloir supprimer ce produit ?")) {
            window.location = "supprimer.php?id=" + id
        }
    }
</script>
<?php //if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) { 
?>
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">Liste des produits</a>
        <a href="formAjout.php" class="btn btn-primary d-flex">Ajouter un produit</a>
    </div>
</nav>

<body>
    <div class="container-fluid">
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $prod) : ?>
                    <tr id="<?php echo $prod['id']; ?>">
                        <td><?php echo $prod['titre']; ?></td>
                        <td><?php echo $prod['description']; ?></td>
                        <td><?php echo $prod['prix']; ?></td>
                        <td>
                            <a href="formModif.php?id=<?php echo $prod['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <button class="btn btn-danger btn-sm" onclick="supprimer(<?php echo $prod['id']; ?>)">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php
// } 
?>

</html>