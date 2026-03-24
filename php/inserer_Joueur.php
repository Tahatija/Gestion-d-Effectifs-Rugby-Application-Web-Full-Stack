<?php
require_once 'fonction_Joueur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouveauJoueur = [
        'nom_joueur' => $_POST['nom_joueur'],
        'jou_nationalite' => $_POST['jou_nationalite'],
        'jou_taille' => $_POST['jou_taille'],
        'jou_poids' => $_POST['jou_poids'],
        'jou_poste' => $_POST['jou_poste'],
        'id_equipe' => $_POST['id_equipe']
    ];

    $joueurInsere = insertJoueur($nouveauJoueur);

    if (isset($joueurInsere['id_joueur'])) {
        // Redirection simplifiée vers la liste des joueurs
        header('Location: affichage.php?table=G20_Joueur');
        exit();
    } else {
        echo "Erreur d'insertion. Équipe inexistante";
    }
}
?>


