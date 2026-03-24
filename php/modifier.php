<?php

require_once 'monEnv.php';
$connection = connexion();


if (!isset($_GET['id']) || !isset($_GET['table'])) {
    echo "Paramètres manquants.";
    exit;
}




$id = $_GET['id'];
$table = $_GET['table'];

// Détermination de la clé primaire de la table
if (stripos($table, 'joueur') !== false) {
    $idField = 'id_joueur';
} elseif (stripos($table, 'equipe') !== false) {
    $idField = 'id_equipe';
} else {
    echo "Table non reconnue.";
    exit;
}

// Récupération des données à modifier
$query = "SELECT * FROM $table WHERE $idField = $1";
$result = pg_query_params($connection, $query, [$id]);
$data = pg_fetch_assoc($result);

if (!$data) {
    echo "Aucun enregistrement trouvé.";
    exit;
}

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = array();
    foreach ($_POST as $column => $value) {
        if ($column != 'id' && $column != 'table') {
            $updatedData[$column] = $value;
        }
    }

    $setClause = array();
    $params = array();
    $paramIndex = 1;

    foreach ($updatedData as $column => $value) {
        $setClause[] = "$column = $" . $paramIndex;
        $params[] = $value;
        $paramIndex++;
    }

    $params[] = $id; // Ajout de l'ID à la fin
    $setClauseStr = implode(", ", $setClause);

    $updateQuery = "UPDATE $table SET $setClauseStr WHERE $idField = $" . $paramIndex;
    $result = pg_query_params($connection, $updateQuery, $params);

    if ($result) {
        // Rediriger vers la liste après succès
        header("Location: affichage.php?table=" . urlencode($table));
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
echo '<a href="affichage.php">Retour à la liste</a>';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Modifier <?= htmlspecialchars($table) ?></title>
</head>
<body>

<h1>Modifier <?= htmlspecialchars($table) ?></h1>

<form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($data[$idField]) ?>">
    <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">

<?php foreach ($data as $column => $value): ?>
    <?php if ($column != $idField): ?>
        <label for="<?= htmlspecialchars($column) ?>"><?= htmlspecialchars($column) ?>:</label>
        <input 
            type="<?= ($column == 'jou_poids' || $column == 'jou_taille' || $column == 'id_equipe') ? 'number' : 'text' ?>"
            name="<?= htmlspecialchars($column) ?>" 
            id="<?= htmlspecialchars($column) ?>" 
            value="<?= htmlspecialchars($value) ?>" 
            required
            <?= ($column == 'jou_poids' || $column == 'jou_taille' || $column == 'id_equipe') ? 'step="any"' : '' ?>
        ><br>
    <?php endif; ?>
<?php endforeach; ?>


    <input type="submit" value="Mettre à jour">
</form>

</body>
</html>
