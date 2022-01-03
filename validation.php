<?php require('./header.php');
include('./function.php');


?>
<section class="container page_header">
    <div class="row">
        <div class="col">
            <h1></h1>
            <span class="breadcrums"></span>
        </div>
    </div>
</section>



<section class="container w-50  flex-wrap validation ">
    <div class=" d-flex justify-content-between flex-wrap">
        <?php show_validation(); ?>
    </div>

    <div class="col-md-3   d-flex flex-column text-center ">
                <i class="fas fa-home pb-4" style="font-size: 5rem;"></i>

                <h4>
                    Modifier mon adresse de livation 
                </h4>
                <form action="./index.php" method="post">
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_adress">modifier votre adresse :</label>
                        <input type="text" name="update_adress" id="update_adress">
                        <input type="hidden" >
                    </div>
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_code_postal">modifier votre code postal :</label>
                        <input type="text" name="update_code_postal" id="update_code_postal">
                        <input type="hidden" >
                    </div>
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_ville">modifier votre ville :</label>
                        <input type="text" name="update_ville" id="update_ville">
                        <input type="hidden" >
                    </div>
                    <div class="d-flex w-50 mt-3 flex-column text-center pb-3">
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <input type="hidden" >
                    </div>
                </form>
            </div>

<div class="validation-btn">
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
</div>

</section>
<?php require('./footer.php') ?>