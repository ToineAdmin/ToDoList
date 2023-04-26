<?php
session_start();
if (isset($_POST['user'])) {
  $_SESSION['user'] = $_POST['user'];
};

if (isset($_SESSION['user'])) {
  echo '<h2> Bonjour ' . ucfirst($_SESSION['user']) . '</h2>';
};
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>ToDoList</title>
</head>

<body>
  <header>
    <?php
    if (isset($_POST['disconect'])) {
      session_destroy();
    };
    ?>
    <form action="conect.php" method="POST">
        <button type="submit" name="disconect" class="disconect-btn">Se déconnecter</button>
    </form>

  </header>
  <?php
  $erreurs = "";
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=tâches;charset=utf8', 'root', '');
  } catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
  };
  // AJOUTER UNE TACHE
  if (isset($_POST['add_task'])) {
    if (empty($_POST['add_task'])) {
      $erreurs = 'Vous devez indiquer la valeur de la tâche';
    } else {
      $tache = $_POST['add_task'];
      $requete = $bdd->prepare("INSERT INTO todo (task) VALUES (:task)");
      $requete->bindParam(':task', $tache);
      $requete->execute();
    }
  }
  // SUPPRIMER UNE TACHE
  if (isset($_POST['supp_task'])) {
    if (empty($_POST['supp_task'])) {
      $erreurs = 'Vous devez choisir une tâche à suprrimer'; // Peut être à supprimer car supp_task jamais vide ? donc inutile d'avoir un message d'erreur ? 
    } else {
      $id = $_POST['supp_task'];
      $requete = $bdd->prepare("DELETE FROM todo WHERE id=:id");
      $requete->bindParam(':id', $id);
      $requete->execute();
    }
  }
  // MODIFIER UNE TACHE
  if (isset($_POST['edit'])) { // si le bouton edit est cliqué 
    $id = $_POST['task_id'];
    $new_task_name = $_POST['new_task_name'];
    $requete = $bdd->prepare("UPDATE todo SET task=:task WHERE id=:id"); // on pourrait mettre à la place de :task et :id directement $new_task_name et $id ? mais plus sécurisé grâce a bindparram ?? 
    $requete->bindParam(':task', $new_task_name);
    $requete->bindParam(':id', $id);
    $requete->execute();
  }
  ?>

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
          <p><?= $erreurs ?></p>
        <?php endif; ?>
        <ul>
          <?php
          $requete = $bdd->query('SELECT * FROM todo'); //recupère les données de la table
          while ($donnees = $requete->fetch()) { // TANT QU'il y a des données affiche ...
          ?>
            <li><?= $donnees['task'] ?>
              <form action="projet.php" method="POST">
                <button type="submit" name="supp_task" value="<?= $donnees['id'] ?>">Supprimer</button>
              </form>
              <form method="POST">
                <input type="hidden" name="task_id" value="<?= $donnees['id'] ?>">
                <button type="submit" name="modifier">Modifier</button>
              </form>
              <?php
              // RECUPERE LES DONNEES DEJA RENTREES
              if (isset($_POST['modifier']) && isset($_POST['task_id'])) { // si le bouton modifier est cliqué et que la donnée à modifié existe ...
                $task_id = $_POST['task_id'];
                $requete = $bdd->prepare('SELECT * FROM todo WHERE id = :id'); // récupère la donnée correspondante
                $requete->bindParam(':id', $task_id);
                $requete->execute();
                $donnees = $requete->fetch(); // affiche la donnée 
                if ($donnees) {
              ?>
                  <form method="POST">
                    <input type="text" name="new_task_name" value="<?= $donnees['task'] ?>">
                    <input type="hidden" name="task_id" value="<?= $donnees['id'] ?>"> // permet de récupéré l'id de la donnée à modifier
                    <button type="submit" name="edit">Enregistrer</button>
                  </form>
            <?php
                }
              }        // mieux d'utiliser " : " après les if et while pour pour finir par endif endif endwhile ? plus lisible ?
            }
            ?>