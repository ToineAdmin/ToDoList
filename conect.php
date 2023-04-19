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
    <main>
        <div class="card">
            <div class="card-title">
            <h2>Connexion</h2>
        </div>
        <div class="card-body">
            <form action="projet.php" method="POST">
                <label for="user">Username: </label>
                <input type="text" class="input" name="user">
                <label for="mdp">Mot de passe: </label>
                <input type="text" class="input" name="mdp">
                <button type="submit">Ajouter</button>
                <a href="inscription.php">S'inscrire</a>
            </form>
        </div>
    </main>
</body>

</html>

