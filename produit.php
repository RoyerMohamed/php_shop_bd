<?php 
require('./header.php');
include('./function.php') ; 
session_start(); 
$product_id = ""; 
if(isset($_POST['product_id'])){
    $product_id = $_POST['product_id']; 
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
<?php show_single_product($product_id)?>


<?php require('./footer.php') ?>