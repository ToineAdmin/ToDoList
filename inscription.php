<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>

<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=inscription;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
};


$erreur = "";



if (isset($_POST['create_user']) && isset($_POST['create_mdp'])) {
    $add_user = $_POST['create_user'];
    $add_mdp = $_POST['create_mdp'];
    
    if (empty($add_user) || empty($add_mdp)) {
        $erreur = "Veuillez rentrer un nom d'utilisateur et/ou un mot de passe";
    }
    else if(strlen($add_user) < 3 || strlen($add_user) > 20) {
        $erreur = "Le nom d'utilisateur doit avoir entre 3 et 20 caractères";
    }
    else{
        $requete = $bdd->prepare('SELECT * FROM users WHERE user = :user');
        $requete->bindParam(':user', $add_user);
        $requete->execute();

        if($requete->fetchColumn() > 0) {
            $erreur = "Le nom d'utilisateur est déjà utilisé";
        }
        else if((!preg_match('/[A-Z]/', $add_mdp) || !preg_match('/\d/', $add_mdp)) && strlen($add_mdp) < 8 ){
            $erreur = "Le mot de passe doit contenir au moins une majuscule et un chiffre et avoir minimum 8 caractères";
        }
        else{
            $requete = $bdd->prepare('INSERT INTO users (user, mdp) VALUES (:user, :mdp)');
            $requete->bindParam(':user', $add_user);
            $requete->bindParam(':mdp', $add_mdp);
            $requete->execute();
        }
    }
}


?>

<body>
    <main>
        <div class="card">
            <div class="card-title">
                <h2>Inscription</h2>
            </div>
            <div class="card-body">
                <form class="inscription" action="inscription.php" method="POST">
                    <label for="create_user">Choisissez un Username: </label>
                    <input type="text" class="input" name="create_user" placeholder="entre 3 et 20 caractères">
                    <label for="create_mdp">Choisissez un mot de passe: </label>
                    <input type="password" class="input" name="create_mdp" placeholder="au moins 1 majuscule et un chiffre">
                    <?php if (!empty($erreur)) : ?>
                        <p style="color:red;"><?= $erreur ?></p>
                    <?php endif; ?>
                    <button type="submit">S'inscrire</button>
                    <a href="conect.php">Retour</a>
                </form>
            </div>
    </main>
</body>

</html>