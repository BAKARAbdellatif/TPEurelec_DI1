<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php session_start(); ?>

<body>
    <div class="container-fluid">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <div class="card col-md-8 mx-auto mt-4">
                <div class="card-body">
                    <h5 class="card-title">Formulaire d'authentification</h5>
                    <form method="POST" action="connexion.php" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</body>
<?php if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once("../connexion.php");
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = openConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count, nom, prenom, email from utilisateurs WHERE email LIKE ? and password LIKE ?");
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, md5($password));
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['authenticated'] = true;
    $_SESSION["user"] = serialize(array($resultat['nom'], $resultat['prenom'], $resultat['email']));
    header('Location: ../produit/index.php');
} ?>

</html>