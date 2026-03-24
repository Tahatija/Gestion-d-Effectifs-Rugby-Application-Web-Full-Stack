<?php
require_once 'fonction_Equipe.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouvelleEquipe = [
        'nom_equipe' => $_POST['nom_equipe'],
        'ville' => $_POST['ville']
    ];

    $equipeInseree = insertEquipe($nouvelleEquipe);

    // Vérifier si l'équipe est insérée ou pas et rediriger
    if ($equipeInseree) {
        header('Location: affichage.php?table=G20_Equipe');
        exit();
    } else {
        echo "Erreur lors de l'insertion de l'équipe.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Insertion d'une équipe</title>
</head>
<body>

<h1>Insertion d'une équipe</h1>

<form action="insertion_Equipe.php" method="POST">
    <label>Nom de l'équipe:</label><input type="text" name="nom_equipe" required><br>
    <label>Ville:</label><input type="text" name="ville" required><br>
    <input type="submit" value="Insérer">
</form>

</body>
</html>
