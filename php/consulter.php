<?php
require_once 'monEnv.php';
$connection = connexion();

if (!isset($_GET['id']) || !isset($_GET['table'])) {
    echo "Paramètres manquants.";
    exit;
}


$id = $_GET['id'];
$table = $_GET['table'];

if ($table == 'g20_joueur') {
    $idField = 'id_joueur';
} elseif ($table == 'g20_equipe') {
    $idField = 'id_equipe';
} else {
    echo "Table non reconnue.";
    exit;
}

$query = "SELECT * FROM $table WHERE $idField = $1";
$result = pg_query_params($connection, $query, array($id));
$data = pg_fetch_assoc($result);

if (!$data) {
    echo "Aucun enregistrement trouvé.";
    exit;
}

echo "<h1>Détails de l'enregistrement</h1>";
echo "<ul>";
foreach ($data as $key => $value) {
    echo "<li><strong>" . htmlspecialchars($key) . ":</strong> " . htmlspecialchars($value) . "</li>";
}
echo "</ul>";

echo '<a href="affichage.php">Retour à la liste</a>';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma page</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers ton fichier CSS -->
</head>
<body>
    <!-- Ton contenu HTML généré par PHP -->
</body>
</html>
