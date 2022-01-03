<?php
include('./function.php');
require('./header.php');


?>
<section class="container vh-100">
    <h1 class="text-center pb-5">mon profil </h1>
    <div class="container " style="color: white;">
        <div class="row">

            <div class="col-md-3 d-flex flex-column text-center ">
                <i class="fas fa-users pb-4  " style="font-size: 5rem;"></i>
                <h4>
                    Modifier mes information
                </h4>
                <form action="./index.php" method="POST">
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_nom">modifier votre nom :</label>
                        <input type="text" name="update_nom" id="update_nom">
                        <input type="hidden" >
                    </div>
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_prenom">modifier votre prenom :</label>
                        <input type="text" name="update_prenom" id="update_prenom">
                        <input type="hidden" >
                    </div>
                    <div class="d-flex w-50 mt-3 flex-column text-center pb-3">
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <input type="hidden">
                    </div>
                </form>
            </div>

            <div class="col-md-3 d-flex flex-column text-center ">
                <i class="fas fa-key pb-4  " style="font-size: 5rem;"></i>
                <h4>
                    Modifier mon mot de passe
                </h4>
                <form action="./index.php" method="post">
                    <div class="d-flex flex-column text-center pb-3">
                        <label for="update_pass">modifier votre mot de pass :</label>
                        <input type="text" name="update_pass" id="update_pass">
                        <input type="hidden" >
                    </div>

                    <div class="d-flex w-50 mt-3 flex-column text-center pb-3">
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <input type="hidden">
                    </div>
                </form>

            </div>

            <div class="col-md-3   d-flex flex-column text-center ">
                <i class="fas fa-home pb-4" style="font-size: 5rem;"></i>

                <h4>
                    Modifier mon adresse
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