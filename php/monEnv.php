<?php

$_ENV['dbHost']='adresse_ip_du_serveur';
$_ENV['dbName']='nom_de_la_base';
$_ENV['dbUser']='utilisateur';
$_ENV['dbPasswd']='mot_de_passe';

function connexion() {
    $strConnex = "host={$_ENV['dbHost']} dbname={$_ENV['dbName']} user={$_ENV['dbUser']} password={$_ENV['dbPasswd']}";
    $ptrDB = pg_connect($strConnex);

    if (!$ptrDB) {
        die("Erreur de connexion: " . pg_last_error());
    }

    return $ptrDB;
}
?>
