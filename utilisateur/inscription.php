<?php
session_start();
function validerFormulaire($form)
{
    $values = [];
    $errors = [];
    foreach (array_keys($form) as $key) {
        $tempArray = $form[$key];

        for ($i = 0; $i < sizeof($tempArray); $i++) {
            if ($i == 0) {
                $values[$key] = $tempArray[$i];
            } else {
                if (strpos($tempArray[$i], ":") !== false) {
                    if (strpos($tempArray[$i], "minLength") !== false) {
                        $minlength = explode(':', $tempArray[$i])[1];

                        if (strlen($values[$key]) < $minlength) {
                            $errors[$key] = "Ce doit contenir au moins $minlength caractères.";
                            break;
                        }
                    } elseif (strpos($tempArray[$i], "match") !== false) {
                        $matchVal =  explode(':', $tempArray[$i])[1];
                        if ($values[$key] != $values[$matchVal]) {
                            $errors[$key] = "Les mots de passe ne correspondent pas.";
                        }
                    }
                } else {
                    if ($tempArray[$i] == "required") {
                        if (!$values[$key]) {
                            $errors[$key] = "Ce champ est obligatoire.";
                            break;
                        }
                    } elseif ($tempArray[$i] == "email") {
                        if (!filter_var($values[$key], FILTER_VALIDATE_EMAIL)) {
                            $errors[$key] = "Veuillez saisir un email valide";
                            break;
                        }
                    }
                }
            }
        }
    }
    return ["oldvalues" => $values, "errors" => $errors];
}
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_SESSION['errors'])) {
                $errors = $_SESSION['errors'];
                unset($_SESSION['errors']);
            }
            if (isset($_SESSION['oldvalues'])) {
                $oldvalues = $_SESSION['oldvalues'];
                unset($_SESSION['oldvalues']);
            }
        ?>
            <form method="POST" action="inscription.php" novalidate>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom1" value="<?php if (isset($oldvalues['nom'])) {
                                                                                            echo $oldvalues['nom'];
                                                                                        } ?>">
                    <span class="text-danger"><?php if (isset($errors['nom'])) {
                                                    echo $errors['nom'];
                                                } ?></span>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input class="form-control" type="text" name="prenom" id="prenom" value="<?php if (isset($oldvalues['prenom'])) {
                                                                                                    echo $oldvalues['prenom'];
                                                                                                } ?>">
                    <span class="text-danger"><?php if (isset($errors['prenom'])) {
                                                    echo $errors['prenom'];
                                                } ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php if (isset($oldvalues['email'])) {
                                                                                                echo $oldvalues['email'];
                                                                                            } ?>">
                    <span class="text-danger"><?php if (isset($errors['email'])) {
                                                    echo $errors['email'];
                                                } ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" value="<?php if (isset($oldvalues['password'])) {
                                                                                                            echo $oldvalues['password'];
                                                                                                        } ?>">
                    <span class="text-danger"><?php if (isset($errors['password'])) {
                                                    echo $errors['password'];
                                                } ?></span>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?php if (isset($oldvalues['password_confirm'])) {
                                                                                                                            echo $oldvalues['password_confirm'];
                                                                                                                        } ?>">
                    <span class="text-danger"><?php if (isset($errors['password_confirm'])) {
                                                    echo $errors['password_confirm'];
                                                } ?></span>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        <?php
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $form['nom'] = [$nom, "required"];
            $form['prenom'] = [$prenom, "required"];
            $form['email'] = [$email, "required", "email"];
            $form['password'] = [$password, "required", "minLength:8"];
            $form['password_confirm'] = [$password_confirm, "required", "match:password"];
            $validation = validerFormulaire($form);
            $errors = $validation['errors'];
            $oldvalues = $validation['oldvalues'];
            if (sizeof($errors) > 0) {
                $_SESSION["errors"] = $errors;
                $_SESSION["oldvalues"] = $oldvalues;
                header("Location: inscription.php");
            } else {
                require_once("../connexion.php");
                $conn = openConnection();
                $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bindParam(1, $oldvalues['nom']);
                $stmt->bindParam(2, $oldvalues['prenom']);
                $stmt->bindParam(3, $oldvalues['email']);
                $stmt->bindParam(4, md5($oldvalues['password']));
                $stmt->execute();
                $conn = null;
                header("Location: connexion.php");
            }
        }
        ?>
    </div>
</body>

</html>