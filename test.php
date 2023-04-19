<!-- CONNECT / OPERATIONS (LIRE / ECRIRE / MODIFIER / SUPPRIMER) 

mysql_ => extension qui communique avec mySQL mais vieille donc à ne pas utiliser.

mysqli_ => extension avec fonction amélioré

PDO => très sécurisé, pour mySQL, Oracle et postgreSQL -> très utilisé !

-->
<?php
// pour se connecter il nous faut un HOTE : localhost ou sql.monserveur.com (si sur internet)
// il faut un nom de la BASE : formation_users
// il faudra un LOGIN: root
// MDP : normalement pas besoin

// CONECTION -> à faire une seule fois par page
try {
    $bdd = new PDO('mysql:host=localhost;dbname=formation_users;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
};


// AJOUTER UN UTILISATUER DANS LA BDD

// $requete = $bdd->exec('INSERT INTO users(prenom, nom, serie_prefere)
//   VALUES("Mark", "Zukerberg", "YOU")') or die(print_r($bdd->errorInfo())); // la fin pour afficher si erreur il y a




// MODIFIER BDD 

/*$requete = $bdd->exec('UPDATE users SET serie_prefere = "Game of Thrones" WHERE prenom= "Nicolas"'); */


// SUPPRIMER DES DONNEES 


// $requete = $bdd->exec('DELETE FROM users WHERE prenom = "Mark"');


// FAIRE UNE JOINTURE ENTRE PLUSIEURS TABLE

// WHERE : moins utilisé , moins clair

/*
$requete = $bdd->query('SELECT prenom, nom, serie_prefere, metier
                        FROM users, jobs
                        WHERE users.id = jobs.id_users
                        ');
*/

// JOIN : plus en plus choisi, plus clair

/*
$requete = $bdd->query('SELECT prenom, nom, serie_prefere, metier
FROM users
INNER JOIN jobs 
ON users.id = jobs.id_users'):
*/


// $requete = $bdd->exec('INSERT INTO jobs(id_users, metier) VALUES(4, "Musicien")');


// JOINTURE EXTERNE 

/*
$requete = $bdd->query('SELECT prenom, nom, serie_prefere, metier
FROM users
LEFT JOIN jobs 
ON users.id = jobs.id_users
*/


// SECURITE !! Anti Injection de données !! ! !
/*
$prenom = "Alain";
$requete = $bdd->prepare('SELECT prenom, nom, serie_prefere, metier
                        FROM users
                        INNER JOIN jobs 
                        ON users.id = jobs.id_users
                        WHERE prenom = ?');
$requete->execute(array($prenom));
*/


// LIRE des informations

$requete = $bdd->query('SELECT prenom, nom, serie_prefere, metier
                        FROM users
                        INNER JOIN jobs 
                        ON users.id = jobs.id_users
                        ');
echo '<table>
<tr>
    <th> Pseudo </th>
    <th> Nom </th>
    <th> Série préférée </th>
    <th> MDP </th>
</tr>';

while ($donnees = $requete->fetch()) {
    echo '<tr>
            <td>'.$donnees['prenom'].' </td>
            <td>'.$donnees['nom'].' </td>
            <td>'.$donnees['serie_prefere'].' </td>
            <td>'.sha1($donnees['metier']).' </td>
          </tr>';
                
};
$requete-> closeCursor();
    echo '</table>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>