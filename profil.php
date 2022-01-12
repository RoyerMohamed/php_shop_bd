<?php
include('./function.php');
require('./header.php');


?>
<section class="container vh-100">
    <h1 class="text-center pb-5">mon profil </h1>
    <div class="container " style="color: white;">
        <div class="row">
            <?= show_uptate_information("index.php" , "") ?>  
            <?php show_uptate_pass("index.php") ?>
            <?= show_uptate_adress("index.php" , "") ?>

            <div class="col-md-3 d-flex flex-column text-center ">
                <i class="fas fa-archive pb-4  " style="font-size: 5rem;"></i>
                <form action="./commandes.php" method="post">
                    <input type="submit" value=" Liste des commandes" >
                </form>
            </div>
        </div>

    </div>
    <!-- modal Modifier mes information -->







    <!-- modal Modifier adresse-->

    <div class="modal fade" id="Modifier_mon_adresse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                </div>
            </div>
        </div>
    </div>


</section>

<?php require('./footer.php') ?>