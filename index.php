<?php
include('./function.php');
require('./header.php');
session_start(); 
if(isset($_POST['validation_de_commande'])){
    delete_all_products();
  }

 if (
    isset($_POST["mot_de_passe_conection"])
    && isset($_POST["email_conection"])
) {
    user_connection();
}


?>
<main class="container-fluid">
    <section class="container hero">
        <div class="row h-100 d-flex align-content-center flex-wrap">
            <div class=" col-md-6 hero_text w-50">
                <h1>Marijuana médicale
                    Boutique de produits</h1>
                <p>Cras maximus, elit at maximus feugiat, nisi sapien mollis metus,
                    vitae ultricies nunc magna vel mi.</p>
                <ul>
                    <li><i class="fas fa-check-circle"></i>Les meilleurs produits à base de marijuana</li>
                    <li><i class="fas fa-check-circle"></i>De nombreux points de vente</li>
                    <li><i class="fas fa-check-circle"></i>Des conseils de professionnels</li>
                </ul>
                <a href="./contact.php" class="hero_text_btn">en savoir plus</a>

            </div>

            <div class="col-md-6 hero_img w-50">
                <img src="./assets/img/hero_img.png" alt="image fleure " srcset="">
            </div>

        </div>
    </section>
    <section class="container categories ">

  <?php show_multiple_products() ?>
    </section>

</main>

<?php require('./footer.php') ?>