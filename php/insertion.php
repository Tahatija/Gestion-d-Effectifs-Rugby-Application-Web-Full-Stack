<?php
session_start();

if (!isset($_SESSION['table'])) {
    header('Location: index.php');
    exit();
}

$table = $_SESSION['table'];

// Rediriger vers le bon formulaire selon le nom de la table
if (stripos($table, 'joueur') !== false) {
    header('Location: insertion_Joueur.html');
    exit();
} elseif (stripos($table, 'equipe') !== false) {
    header('Location: insertion_Equipe.html');
    exit();
} else {
    echo "Aucun formulaire disponible pour la table : " . htmlspecialchars($table);
}
?>
