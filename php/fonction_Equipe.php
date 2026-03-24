<?php
require 'monEnv.php';

// function connexion() {
//     $strConnex = "host={$_ENV['dbHost']} dbname={$_ENV['dbName']} user={$_ENV['dbUser']} password={$_ENV['dbPasswd']}";
//     $ptrDB = pg_connect($strConnex);

//     if (!$ptrDB) {
//         die("Erreur de connexion: " . pg_last_error());
//     }

//     return $ptrDB;
// }

// Récuperation d'une équipe par son id 
function getEquipeById(int $id): array {
    $ptrDB = connexion();
    $query = "SELECT * FROM G20_Equipe WHERE id_equipe = $1";
    
    pg_prepare($ptrDB, "reqPrepSelectEquipeById", $query);
    $resultat = pg_execute($ptrDB, "reqPrepSelectEquipeById", [$id]);
    
    $equipe = pg_fetch_assoc($resultat);
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $equipe ?: ["message" => "Équipe non trouvée (id: $id)"];
}

// Récupération de tous les équipes
function getAllEquipes(): array {
    $ptrDB = connexion();
    $query = "SELECT * FROM G20_Equipe ORDER BY id_equipe ASC";
    
    $resultat = pg_query($ptrDB, $query);
    $equipes = [];
    
    while ($row = pg_fetch_assoc($resultat)) {
        $equipes[] = $row;
    }
    
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $equipes;
}

// Insertion d'une nouvelle equipe
function insertEquipe(array $equipe): array {
    $ptrDB = connexion();
    $query = "INSERT INTO G20_Equipe (nom_equipe, ville) VALUES ($1, $2) RETURNING id_equipe";
    
    pg_prepare($ptrDB, "reqPrepInsertEquipe", $query);
    $resultat = pg_execute($ptrDB, "reqPrepInsertEquipe", [$equipe['nom_equipe'], $equipe['ville']]);
    
    $nouvId = pg_fetch_result($resultat, 0, 0);
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return getEquipeById($nouvId);
}

// Mettre a jour les infos d'une equipe
function updateEquipe(array $equipe): array {
    $ptrDB = connexion();
    $query = "UPDATE G20_Equipe SET nom_equipe = $1, ville = $2 WHERE id_equipe = $3 RETURNING *";
    
    pg_prepare($ptrDB, "reqPrepUpdateEquipe", $query);
    $resultat = pg_execute($ptrDB, "reqPrepUpdateEquipe", [
        $equipe['nom_equipe'],
        $equipe['ville'],
        $equipe['id_equipe']
    ]);
    
    $updatedEquipe = pg_fetch_assoc($resultat);
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $updatedEquipe ?: ["message" => "Échec de la mise à jour"];
}

//Suppression d'une équipe
function deleteEquipe(int $id): bool {
    $ptrDB = connexion();
    $query = "DELETE FROM G20_Equipe WHERE id_equipe = $1";
    
    pg_prepare($ptrDB, "reqPrepDeleteEquipe", $query);
    $resultat = pg_execute($ptrDB, "reqPrepDeleteEquipe", [$id]);
    
    $rowsAffected = pg_affected_rows($resultat);
    pg_close($ptrDB);
    
    return $rowsAffected > 0;
}

?>