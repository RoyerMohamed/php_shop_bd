<?php require('./header.php');
include('./function.php');
if (
  isset($_POST['update_adress']) && isset($_POST['update_code_postal']) && isset($_POST['update_ville'])

) {
  $data =  [
    "id" => intval($_SESSION["user_info"][0]),
    "adress" => $_POST['update_adress'],
    "code_postal" => $_POST['update_code_postal'],
    "ville" => $_POST['update_ville']
  ];
  uptate_adress();
}
if(isset($_POST['validation_de_paiment'])){
  echo"JE SUIS LA "; 
}
var_dump(get_all_orders_by_user()) ;

?>
<section class="container page_header">
  <div class="row">
    <div class="col">
      <h1></h1>
      <span class="breadcrums"></span>
    </div>
  </div>
</section>

<?= show_validation(); ?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Valider ma commande
    </button>
<?php require('./footer.php') ?>