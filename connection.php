<?php
include('./function.php');
require('./header.php');
session_start();
if (
    isset($_POST["nom_inscription"])
    && isset($_POST["prenom_inscription"])
    && isset($_POST["email_inscription"])
    && isset($_POST["mot_de_passe_inscription"])
){
    $user = [
        "nom" => $_POST["nom_inscription"],
        "prenom" => $_POST["prenom_inscription"],
        "email" => $_POST["email_inscription"],
        "mot_de_passe" => $_POST["mot_de_passe_inscription"]
    ];
    add_user($user);  
}
?>

<section>
    <?= Show_connection() ?>
</section>
<?php require('./footer.php') ?>