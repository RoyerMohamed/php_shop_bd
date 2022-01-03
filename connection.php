<?php
include('./function.php');
require('./header.php');
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
        "mot_de_passe" => $_POST["mot_de_passe_inscription"],
        "adresse" => $_POST["adresse"],
        "code_postal" => $_POST["code_postal"],
        "ville" => $_POST["ville"]
    ];
    add_user($user);  
}
// if (isset($_POST["adresse"])
// && isset($_POST["code_postal"]) 
// && isset($_POST["ville"])){
//     add_user_infos()
// }
?>

<section class="container d-flex justify-content-center vh-100 align-items-center justify-content-around flex-column">
    <?= Show_connection() ?>    
</section>
<?php require('./footer.php') ?>