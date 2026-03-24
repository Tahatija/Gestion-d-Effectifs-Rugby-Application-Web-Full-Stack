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

// Exécution de la requête de suppression
$query = "DELETE FROM $table WHERE $idField = $1";
$result = pg_query_params($connection, $query, [$id]);

if ($result) {
    // Redirection vers la page de liste après suppression
    header("Location: affichage.php?table=" . urlencode($table));
    exit; // Ne pas oublier de quitter le script après la redirection
} else {
    echo "Erreur lors de la suppression de l'enregistrement.";
}
?>
