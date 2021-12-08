<?php
include('./function.php');
require('./header.php');
session_start();
if (
    isset($_POST["nom_inscription"])
    && isset($_POST["prenom_inscription"])
    && isset($_POST["email_inscription"])
    && isset($_POST["mot_de_passe_inscription"])
    && isset($_POST["clients_id"])
){
    $user = [
        "id" => $_POST["clients_id"],
        "nom" => $_POST["nom_inscription"],
        "prenom" => $_POST["prenom_inscription"],
        "email" => $_POST["email_inscription"],
        "mot_de_passe" => $_POST["mot_de_passe_inscription"]
    ];
    add_user($user);
    user_verification($_POST["clients_id"]);

}


?>

<section class="container w-50 vh-100">
<?= show_inscription() ?>
</section>


<?php require('./footer.php') ?>