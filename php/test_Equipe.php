<?php
require 'fonction_Equipe.php'; 

/******décommentez ou commentez chaque test pour tester son fonctionnement******/


// Test de getEquipeById()
echo "Équipe existante:<br />";
print_r(getEquipeById(2)); // Doit retourner Stade Français Paris Rugby
echo "<br /><br />";

echo "Équipe inexistante:<br />";
print_r(getEquipeById(999)); // Doit retourner une d'erreur
echo "<br /><br />";

/*
// Test de insertEquipe() 
echo "Insertion d'une nouvelle équipe:<br />";
$nouvelleEquipe = [
    'nom_equipe' => 'Rugby Club Toulonnais',
    'ville' => 'Toulon'
];
print_r(insertEquipe($nouvelleEquipe)); // Doit retourner la nouvelle équipe
echo "<br /><br />"; */

/*
// Test de updateEquipe() 
echo "Modification équipe:<br />";
$equipe = getEquipeById(1); // Lyon
$equipe['ville'] = 'Lyon-Villeurbanne';
print_r(updateEquipe($equipe)); 
echo "<br /><br />"; */

/*
//test de deleteEquipe()
echo "Suppression équipe:<br />";
$toutesEquipes = getAllEquipes();
$derniereEquipe = end($toutesEquipes);
if ($derniereEquipe) {
    deleteEquipe($derniereEquipe['id_equipe']);
    print_r(getEquipeById($derniereEquipe['id_equipe']));
} else {
    echo "Aucune équipe à supprimer";
}
echo "<br /><br />"; */

/*
// Test de getAllEquipes() 
echo "Liste de toutes les équipes:<br />";
print_r(getAllEquipes()); 
echo "<br /><br />";*/
?>