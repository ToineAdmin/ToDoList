<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ToDoList</title>
</head>
<?php 
$erreur = "";
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tâches;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
};

if (isset($_POST['add_task'])) { // On vérifie que la variable POST existe
    if (empty($_POST['add_task'])) {  // On vérifie qu'elle a une valeure
        $erreurs = 'Vous devez indiquer la valeure de la tâche';
    } else {
        $tache = $_POST['add_task'];
        $bdd->exec("INSERT INTO todo(task) VALUES('$tache')"); // On insère la tâche dans la base de donnée
    }
}


?>
<body>
    <main>
        <div class="card">
            <form action="projet.php" method="POST">
                <div class="card-title">
                    <h2>To Do List</h2>
                </div>
                <div class="card-body">
                    <input type="text" class="input" name="add_task"><button>Ajouter</button>
                    <ul>
                        <?php
                           if (isset($erreurs)) {
                        ?>
                            <p><?php echo $erreurs ?></p>
                           
                        <?php
                           }
                        $requete = $bdd->query('SELECT task
                                                FROM todo');
                        while ($donnees = $requete->fetch()) {
                        echo '<li><input type="checkbox">'.$donnees['task'].'</li><button>Supp</button>';
                        };
                        ?>
                    </ul>
                </div>
            </form>    
        </div>


    </main>
</body>

</html>