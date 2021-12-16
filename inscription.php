<?php
include('./function.php');
require('./header.php');
session_start();
?>

<section class="container w-50 vh-100">
<?= show_inscription() ?>
</section>


<?php require('./footer.php') ?>