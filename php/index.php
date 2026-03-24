<?php
session_start();
// Inclure le fichier de configuration de l'environnement
require_once 'monEnv.php';

// Connexion à la base de données
$connection = connexion();

// Récupérer toutes les tables (ajustez cette requête selon vos besoins)
$query = "SELECT table_name FROM information_schema.tables 
          WHERE table_schema = 'public' 
          ORDER BY table_name";

$result = pg_query($connection, $query);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . pg_last_error($connection));
}

// Stocker les tables dans un tableau
$tables = [];
while ($row = pg_fetch_row($result)) {
    $tables[] = $row[0];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestion des Données Rugby</h1>
        <div class="card">
            <h2>Choisissez une table</h2>
            
            <?php if (empty($tables)): ?>
                <p>Aucune table n'a été trouvée dans la base de données.</p>
            <?php else: ?>
                <form action="affichage.php" method="POST">
                    <div class="form-group">
                        <label for="table">Table :</label>
                        <select name="table" id="table" required>
                            <option value="">-- Choisir une table --</option>
                            <?php foreach ($tables as $table): ?>
                                <option value="<?= htmlspecialchars($table) ?>"><?= htmlspecialchars($table) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn primary">Voir</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>