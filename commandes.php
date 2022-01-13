<?php
include('./function.php');
require('./header.php');
 var_dump(get_all_orders_by_user());   

?>
<!-- les info des la commande list -->
<section class="container commandes">

<table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Numero de commande</th>
            <th scope="col">date</th>
            <th scope="col">prix</th>
            <th scope="col">details</th>
          </tr>
        </thead>
        <tbody>
        <?= show_commandes(); ?>
        </tbody>
      </table>
</section>

<?php require('./footer.php') ?>