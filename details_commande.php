<?php
include('./function.php');
require('./header.php');

?>
<!-- les info des la commande -->
<section class="container details">
    <div class="row">
        <div class="col">
            <h4>Date : <?= $_POST['orderDate']  ?> - montant total : <?= $_POST['orderTotal']   ?> </h4>
        </div>
    </div>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">article</th>
      <th scope="col">prix</th>
      <th scope="col">Quantité</th>
      <th scope="col">montant</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
  </tbody>
</table>

</section>

<?php require('./footer.php') ?>