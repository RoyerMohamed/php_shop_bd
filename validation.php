<?php require('./header.php');
include('./function.php');
session_start();
// total des frais , prix 

?>
<section class="container page_header">
    <div class="row">
        <div class="col">
            <h1></h1>
            <span class="breadcrums"></span>
        </div>
    </div>
</section>



<section class="container panier ">
    <div class=" d-flex justify-content-center flex-wrap">
        <?php show_validation(); ?>
    </div>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Valider ma commande
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?= shipping_date();?> </div>
      <div class="modal-footer">
        <form action="/index.php" method="post">
          <input type="submit" class="btn btn-primary" value="Valider">
          <input type="hidden" name="validation_de_commande">
        </form>
      </div>
    </div>
  </div>
</div>
</section>
<?php require('./footer.php') ?>