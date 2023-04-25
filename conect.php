<?php

session_start();
require_once 'config.php'; // Connexion à la base de donnée

if(isset($_POST['user']) && isset($_POST['mdp'])){

    $username = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['mdp']);


    $requete = $bdd->prepare('SELECT * FROM users WHERE user = :user');
    $requete->bindParam(':user', $username); 
    $requete->execute();
    $row = $requete->rowCount(); // récupère le nombre de ligne renvoyée


    if ($row > 0){ // regarde si il y a une correspondance
        $data = $requete->fetchAll();
        if(password_verify($password, $data[0]["mdp"])){ // vérifie si le mdp non hach = celui de la base de donnée
            header('Location:projet.php'); // devrait renvoyer vers projet mais ne le fais pas 
            $_SESSION['username'] = $username; // stock le username dans la globale session
        }
    } else {
        echo 'Nom d\'utilisateur ou mot de passe incorrect.';
    }
};




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Conect</title>
</head>

<body>
    <?php 

    ?>
    <main>
        <div class="card">
            <div class="card-title">
            <h2>Connexion</h2>
        </div>
        <div class="card-body">
            <form action="conect.php" method="POST">
                <label for="user">Username: </label>
                <input type="text" class="input" name="user" required = "required" autocomplete="off">
                <label for="mdp">Mot de passe: </label>
                <input type="password" class="input" name="mdp" required = "required" autocomplete="off">
                <button type="submit">Se Connecter</button>
                <a href="inscription.php">S'inscrire</a>
            </form>
        </div>
    </main>
</body>

</html>

