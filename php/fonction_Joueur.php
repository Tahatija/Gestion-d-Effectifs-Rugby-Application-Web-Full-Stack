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
// Récuperation d'un joueur par son id 
function getJoueurById(int $id): array {
    $ptrDB = connexion();
    $query = "SELECT * FROM G20_Joueur WHERE id_joueur = $1";
    
    pg_prepare($ptrDB, "reqPrepSelectJoueurById", $query);
    $resultat = pg_execute($ptrDB, "reqPrepSelectJoueurById", [$id]);
    
    $joueur = pg_fetch_assoc($resultat);
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $joueur ?: ["message" => "Joueur non trouvé (id: $id)"];
}

// Récupération de tous les joueurs
function getAllJoueurs(): array {
    $ptrDB = connexion();
    $query = "SELECT * FROM G20_Joueur";
    
    $resultat = pg_query($ptrDB, $query);
    $joueurs = [];
    
    while ($row = pg_fetch_assoc($resultat)) {
        $joueurs[] = $row;
    }
    
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $joueurs;
}

// Insertion d'un nouveau joueur
function insertJoueur(array $joueur): array {
    $ptrDB = connexion();
    
    // voir si le poste entrer est valide
    $postesValides = ['Pilier', 'Talonneur', '2ème ligne', '3ème ligne', 
                     'Mêlée', 'Ouverture', 'Centre', 'Ailier', 'Arrière'];
    
    if (!in_array($joueur['jou_poste'], $postesValides)) {
        pg_close($ptrDB);
        return ['erreur' => 'Poste invalide. Choisissez parmi: ' . implode(', ', $postesValides)];
    }
    
    // Vérifie si l'id d'équipe entrer est valide
    $checkEquipe = pg_query($ptrDB, "SELECT 1 FROM G20_Equipe WHERE id_equipe = " . (int)$joueur['id_equipe']);
    if (pg_num_rows($checkEquipe) === 0) {
        pg_close($ptrDB);
        return ['erreur' => 'Équipe inexistante (id: ' . $joueur['id_equipe'] . ')'];
    }
    
    // Insertion du joueur si tout est valide
    $query = "INSERT INTO G20_Joueur (
                nom_joueur, jou_nationalite, jou_taille, jou_poids, jou_poste, id_equipe
              ) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id_joueur";
    
    pg_prepare($ptrDB, "reqPrepInsertJoueur", $query);
    $resultat = pg_execute($ptrDB, "reqPrepInsertJoueur", [
        $joueur['nom_joueur'],
        $joueur['jou_nationalite'],
        $joueur['jou_taille'],
        $joueur['jou_poids'],
        $joueur['jou_poste'],
        $joueur['id_equipe']
    ]);
    
    $nouvId = pg_fetch_result($resultat, 0, 0);
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return getJoueurById($nouvId);
}

// Mettre a jour les infos d'un joueur
function updateJoueur(array $joueur): array {
    $ptrDB = connexion();
    $query = "UPDATE G20_Joueur SET 
                nom_joueur = $1,
                jou_nationalite = $2,
                jou_taille = $3,
                jou_poids = $4,
                jou_poste = $5,
                id_equipe = $6
              WHERE id_joueur = $7";
    
    pg_prepare($ptrDB, "reqPrepUpdateJoueur", $query);
    pg_execute($ptrDB, "reqPrepUpdateJoueur", [
        $joueur['nom_joueur'],
        $joueur['jou_nationalite'],
        $joueur['jou_taille'],
        $joueur['jou_poids'],
        $joueur['jou_poste'],
        $joueur['id_equipe'],
        $joueur['id_joueur']
    ]);
    
    pg_close($ptrDB);
    return getJoueurById($joueur['id_joueur']);
}

//Suppression d'un joueur
function deleteJoueur(int $id): bool {
    $ptrDB = connexion();
    $query = "DELETE FROM G20_Joueur WHERE id_joueur = $1";
    
    pg_prepare($ptrDB, "reqPrepDeleteJoueur", $query);
    $resultat = pg_execute($ptrDB, "reqPrepDeleteJoueur", [$id]);
    
    $rowsAffected = pg_affected_rows($resultat);
    pg_close($ptrDB);
    
    return $rowsAffected > 0;
}

// Récupération des joueurs par leurs id d'équipe
function getJoueursByEquipe(int $id_equipe): array {
    $ptrDB = connexion();
    $query = "SELECT * FROM G20_Joueur WHERE id_equipe = $1";
    
    pg_prepare($ptrDB, "reqPrepSelectJoueurByEquipe", $query);
    $resultat = pg_execute($ptrDB, "reqPrepSelectJoueurByEquipe", [$id_equipe]);
    
    $joueurs = [];
    while ($row = pg_fetch_assoc($resultat)) {
        $joueurs[] = $row;
    }
    
    pg_free_result($resultat);
    pg_close($ptrDB);
    
    return $joueurs;
}
?>