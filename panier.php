<?php require('./header.php');
include('./function.php');
session_start();
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}
if (isset($_POST['delete_product_by_id'])) {
    delete_product_by_id($_POST['delete_product_by_id']);
}
if (isset($_POST['delete_panier'])) {
    delete_all_products();
}


if (isset($_POST['update_new_quantity'])) {
    update_quantity($_POST['modified_product_id'], $_POST['update_new_quantity']);
}

if (isset($_POST['add_to_cart'])) {
    add_to_cart($_POST['add_to_cart']);
}
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
    <h2>Votre panier est de <?php show_cart_total(); ?> </h2>

    <div class=" d-flex justify-content-between flex-wrap"><?php show_cart(); ?></div>
        <div class="row justify-content-between p-5 ">
            <form action="./panier.php" class="col text-center" method="post">
                <input class="btn btn-danger"  type="submit" name="delete_panier" value="vider le panier " />
            </form>
            <form action="./validation.php" class="col text-center" method="post">
                <input class="btn btn-primary" type="submit" name="validation_de_paiment" value="valider votre commande" />
            </form>
        </div>
</section>
<?php require('./footer.php') ?>