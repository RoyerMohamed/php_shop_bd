<?php require('./header.php');
include('./function.php');
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
        <div class="col text-center fs-3" >
            <h1>Panier</h1>
            <h2><?php show_cart_total(); ?></h2>
        </div>
    </div>
</section>

<section class="container panier ">

    <?php show_cart(); ?>
</section>
<div class="row justify-content-between p-5 ">
    
    <?php  btn_validation()?>
</div>
<?php require('./footer.php') ?>