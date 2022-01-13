<?php
include('./function.php');
require('./header.php');
if(isset($_POST['validation_de_commande'])){
  save_ordre();
  }

 if (
    isset($_POST["mot_de_passe_conection"])
    && isset($_POST["email_conection"])
) {
    user_connection();
}

if (isset($_POST["log_out_user"])) {
    log_out_user(); 
}
if(
isset($_POST['update_nom']) && isset($_POST['update_prenom'])
){
  $data = [
      "id" =>  intval($_SESSION["user_info"][0]), 
      "update_nom"=>$_POST['update_nom'],
      "update_prenom"=>$_POST['update_prenom']
  ];
  uptate_information($data);

}
if(isset($_POST['update_adress'])&&isset($_POST['update_code_postal'])&& isset($_POST['update_ville'])){
    uptate_adress();
    echo"je suis la "; 
  }
  if(isset($_POST['old_pass'])){uptate_passe($_POST['old_pass']);}
  echo"<pre>";
  var_dump(intval($_SESSION["user_info"][0]));
  echo"</pre>";


?>
<main class="container-fluid">
    <section class="container hero">
        <div class="row h-100 d-flex align-content-center flex-wrap">
            <div class=" col-md-6  hero_text w-50">
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
    <section class="container-fluid categories ">

  <?php show_multiple_products() ?>
  <div class="modal fade" id="home_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Le produit a été ajouté ! 
     </div>
      <div class="modal-footer">
        <form action="/index.php" method="post">
          <input type="submit" class="btn btn-primary" value="Continuer sur la pasge d'accueil ">
        </form>
        <form action="/panier.php" method="post">
          <input type="submit" class="btn btn-primary" value="Voir mon panier ">
        </form>
      </div>
    </div>
  </div>
</div>
    </section>

</main>

<?php require('./footer.php') ?>