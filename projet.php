<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ToDoList</title>
</head>
<?php
$erreurs = "";
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tâches;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
};

if (isset($_POST['add_task'])) { // On vérifie que la variable POST existe
    if (empty($_POST['add_task'])) {  // On vérifie qu'elle a une valeure
        $erreurs = 'Vous devez indiquer la valeur de la tâche';
    } else {
        $tache = $_POST['add_task'];
        $requete = $bdd->prepare("INSERT INTO todo (task) VALUES (:task)");
        $requete->bindParam(':task', $tache);
        $requete->execute();
    }
}

if (isset($_GET['supp_task'])) {
    $id = $_GET['supp_task'];
    $bdd->exec("DELETE FROM todo WHERE id=$id");
}

?>

<body>
    <main>
        <div class="card">
            <div class="card-title">
                <h2>To Do List</h2>
            </div>
            <div class="card-body">
                <form action="projet.php" method="POST">
                    <input type="text" class="input" name="add_task">
                    <button type="submit">Ajouter</button>
                </form>
                <?php if (!empty($erreurs)) : ?>
                    <p><?php echo $erreurs ?></p>
                <?php endif; ?>
                <ul>
                    <?php
                    $requete = $bdd->query('SELECT id, task FROM todo');
                    while ($donnees = $requete->fetch()) {
                        echo '<li><input type="checkbox">' . $donnees['task'] . ' <a href="projet.php?supp_task=' . $donnees['id'] . '">Supp</a></li>';
                    };
                    ?>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>