<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $_SESSION['table'] = $_POST['table'];
}

if (!isset($_SESSION['table'])) {
    header('Location: index.php');
    exit();
}

require_once 'monEnv.php';
$connection = connexion();

$table = $_SESSION['table'];

// Récupération des données
$query = "SELECT * FROM $table";
$result = pg_query($connection, $query);
$rows = pg_fetch_all($result);

// Redirection formulaire selon le nom de la table
if (stripos($table, 'joueur') !== false) {
    $insertionPage = 'insertion_Joueur.html';
} elseif (stripos($table, 'equipe') !== false) {
    $insertionPage = 'insertion_Equipe.html';
} else {
    $insertionPage = '#';
}

$consulterPage = "consulter.php";
$modifierPage = "modifier.php";
$supprimerPage = "supprimer.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Table <?= htmlspecialchars($table) ?></title>
</head>
<body>
    <h1>Liste des enregistrements de <?= htmlspecialchars($table) ?></h1>
    <a href="index.php">Retour à l'accueil</a> |
    <a href="<?= $insertionPage ?>">Ajouter un nouvel enregistrement</a>

    <?php if (!empty($rows)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <?php foreach ($rows[0] as $column => $value): ?>
                        <th><?= htmlspecialchars($column) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idColonne = array_key_first($rows[0]); // Récupère la première colonne comme ID
                foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?= htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a href="<?= $consulterPage ?>?id=<?= htmlspecialchars($row[$idColonne]) ?>&table=<?= urlencode($table) ?>">Consulter</a>
                            <a href="<?= $modifierPage ?>?id=<?= htmlspecialchars($row[$idColonne]) ?>&table=<?= urlencode($table) ?>">Modifier</a>
                            <a href="<?= $supprimerPage ?>?id=<?= htmlspecialchars($row[$idColonne]) ?>&table=<?= urlencode($table) ?>" onclick="return confirm('Supprimer cet enregistrement ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun enregistrement trouvé dans la table <strong><?= htmlspecialchars($table) ?></strong>.</p>
    <?php endif; ?>
</body>
</html>
