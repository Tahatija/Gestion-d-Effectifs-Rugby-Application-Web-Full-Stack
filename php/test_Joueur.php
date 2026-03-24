<?php
require 'fonction_Joueur.php'; 

/******décommentez ou commentez chaque test pour tester son fonctionnement******/


// affichage de tous les joueurs avec leurs ids
echo "Liste de tous les joueurs et leurs id:<br>";
$tousJoueurs = getAllJoueurs();
foreach ($tousJoueurs as $joueur) {
    echo "id: " . $joueur['id_joueur'] . " - " . $joueur['nom_joueur'] . "<br>";
}

// Test de la fct getJoueurById()
echo "Joueur existant:<br />";
print_r(getJoueurById(10)); // doit retourner le joueur Félix LAMBEY
echo "<br /><br />";

echo "Joueur inexistant:<br />";
print_r(getJoueurById(999)); // Doit retourner un message d'erreur
echo "<br /><br />";


/*
// Test de de la fct insertJoueur() 
echo "Insertion d'un nouveau joueur:<br />";
$nouveauJoueur = [
    'nom_joueur' => 'taha Joueur',
    'jou_nationalite' => 'France',
    'jou_taille' => 180,
    'jou_poids' => 85,
    'jou_poste' => 'Centre',
    'id_equipe' => 3 
];
print_r(insertJoueur($nouveauJoueur)); // Doit retourner le nouveau joueur
echo "<br /><br />"; /*


/*
// Test de la fct updateJoueur()
echo "Modification joueur:<br />";
$joueur = getJoueurById(141); // 
$joueur['jou_poids'] = 163;
print_r(updateJoueur($joueur)); // Doit retourner le joueur modifié
echo "<br /><br />"; */

/*
// Test de la fct deleteJoueur() 
echo "Suppression d'un joueur:<br />";
$tousLesJoueurs = getAllJoueurs();
$dernierJoueur = end($tousLesJoueurs);
deleteJoueur($dernierJoueur['id_joueur']);
print_r(getJoueurById($dernierJoueur['id_joueur'])); // Doit retourner un message d'erreur
echo "<br /><br />"; */

/*
// Test de la fct getAllJoueurs() 
echo "Test getAllJoueurs - Liste complète:<br />";
print_r(getAllJoueurs()); // Doit retourner tous les joueurs restants de la bdd
echo "<br /><br />"; */

/*
// Test de la fct getJoueursByEquipe()
$idEquipe = 2; 
echo "Tous les joueurs de l'équipe d'id $idEquipe:<br>";
print_r(getJoueursByEquipe($idEquipe)); */
?>