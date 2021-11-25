<?php
//add desp_court 
function get_products()
{
    return [
        [
            "name" => "Sweet Pure Auto CBD",
            "id" => "1",
            "Saveur" => "Douce, Fruitée",
            "Effets" => "Relaxant, Stimulant, Stimule la créativité",
            "price" => 29,
            "description_court" => "Cette variété est spécialement conçue pour satisfaire ",
            "description" => "Cette variété est spécialement conçue pour satisfaire les consommateurs de cannabis thérapeutique qui ne souhaitent pas ressentir les effets psychotropes du THC.
            La Sweet Pure Auto CBD® (SWS75) est le résultat de l’hybridation, puis de la sélection, de spécimens riches en CBD et pauvres en THC, entre la Sweet Pure CBD® (SWS65) et notre autofleurissante riche en CBD, la Honey Peach Auto CBD® (SWS64).  
            Les arômes de cette variété sont doux et fruités avec des notes d’agrumes et de cyprès.",
            "picture" => "Sweet_Pure_CBD.jpeg"
        ], [
            "name" => "Black Jack CBD",
            "id" => "2",
            "Saveur" => "Citron, Encens, Fraîche, Douce",
            "Effets" => "Relaxant, Médicinal, Aiguise l’appétit",
            "price" => 39,
            "description_court" => "La plante est très robuste, caractéristique des hybrides indica",
            "description" => "La plante est très robuste, caractéristique des hybrides indica-sativa, très productive avec une grosse tête centrale et de nombreuses autres de gros calibre sur les branches latérales.

            Ses arômes et saveurs sont doux, évoquant l’encens avec des touches fraîches de citron.",

            "picture" => "Black_Jack_CBD.jpeg"
        ], [
            "name" => "Chem Beyond Diesel®, C.B.D",
            "id" => "3",
            "Saveur" => "Épices, Boisée, Diesel, Citron, Épicée, Douce",
            "Effets" => "Médicinal, Aiguise l’appétit, Relaxant",
            "price" => 49,
            "description_court" => "Les arômes et les saveurs de cette variété délicieuse sont",
            "description" => "Les arômes et les saveurs de cette variété délicieuse sont typiquement américains, intenses et chargés de nuances avec des notes douces et boisées, une touche de citron et quelques effluves de poivre et d’épices en conservant un fond aromatique caractéristique de la famille Diesel, subtil mais persistant.",

            "picture" => "Chem_Beyond_Diesel_CBD.jpeg"
        ], [
            "name" => "Cream Caramel CBD",
            "id" => "4",
            "Saveur" => "Agrumes, Terreuse, Caramel, Cyprès, Douce",
            "Effets" => "Relaxant, Médicinal, Aiguise l’appétit",
            "price" => 59,
            "description_court" => "Ses arômes et saveurs sont doux, évoquant le caramel",
            "description" => "Ses arômes et saveurs sont doux, évoquant le caramel, avec un fond terreux et des touches fraîches de cyprès et d’agrumes.            ",

            "picture" => "Cream_Caramel_CBD.jpeg"
        ],

    ];
}

//optimise pas de boucle pour les show


function show_single_product($id)
{
    $products = get_product_by_id($id);

    foreach ($products as $product) {
        $saveur = $product['Saveur'];
        $img = $product['picture'];
        $Effets = $product['Effets'];
        $name = $product['name'];
        $price = $product['price'];
        $description = $product['description'];
        $product_id = $product['id'];

        if ($product['id'] === $id) {
            echo "<section class=\"container annoce-box\">
           <h2 class=\"section-title\">$name</h2>
    
           <div class=\"box-descp\">
               <div class=\"box-descp-left\" style=\"background-image: url(./assets/img/" . $img . "\");>            
               </div>
               <div class=\"box-descp-right\">
                   <div class=\"top\">
                       <span class=\"yellow\">$price €</span>
                       <span class=\"yellow\"><form action=\"./panier.php\" method=\"post\">
                       <button type=\"submit\" class=\"add\"><i class=\"fas yellow fa-cart-plus\"></i></button>
                       <input type=\"hidden\" name=\"add_to_cart\" value=\"$product_id\"/> 
                       </form> </span>
                   </div>
                   <hr>
                   <div class=\"bottom\">
                       <span> Effets <small>$Effets </small></span>
                       <span>Saveur : <small>$saveur</small> </span>
                   </div>
                   <p>$description</p>  
               </div>
           </div>
       </section>";
        }
    }
}
function show_multiple_products()
{
    $products = get_products();
    foreach ($products as $product) {
        $img = $product['picture'];
        $product_id = $product['id'];

        $name = $product['name'];
        $price = $product['price'];
        $description = $product['description_court'];
        echo  "<div class=\" categories_box\" style=\"background-image: url(./assets/img/" . $img . "\"); color:red;\">
          <span class=\"yello\" >   <strong>$name</strong></span>
          <p>$description</p>
          <span class=\"yello\"><strong>$price</strong> 
          <form action=\"./produit.php\" method=\"post\">
          <button type=\"submit\" class=\"add\"> <i class=\"fas yello fa-plus-square\"></i></button>
          <input type=\"hidden\" name=\"product_id\" value=\"$product_id\"/> 
          </form> 
          </span>
 
          </div>
          
          ";
    }
}
function add_to_cart($id)
{
    $product = get_product_by_id($id);
    $product['quantity'] = 1;
    foreach ($_SESSION['panier'] as  $value) {
        if ($id === $value['id']) {
            // show alert 
            return "Produit déja la !!";
        }
    }

    array_push($_SESSION['panier'], $product);
}

function update_quantity($id, $quantity)
{
    for ($i = 0; $i < count($_SESSION['panier']); $i++) {
        if ($_SESSION['panier'][$i]['id'] === $id) {
            $_SESSION['panier'][$i]['quantity'] = $quantity;
        }
    }
}

function delete_product_by_id($id)
{

    foreach ($_SESSION['panier'] as $key => $value) {
        if ($value['id'] == $id) {
            array_splice($_SESSION['panier'], $key, 1);
        }
    }
}
function delete_all_products()
{
    $_SESSION['panier'] = array();
}

function show_validation()
{
    foreach ($_SESSION['panier'] as $product) {
        $quantity = $product['quantity'];
        $img = $product['picture'];
        $name = $product['name'];
        $price = $product['price'];
        $description = $product['description_court'];
        $id = $product['id'];

        echo  "
        <div class=\"col-md-6 d-flex panier_card justify-content-around  mt-5 align-items-center\">
            <div class=\" panier_box\" style=\"background-image: url(./assets/img/" . $img . "\"); color:red;\"></div>
            <div class=\"panier_descp\">
                <span class=\"yello\" ><strong>$name</strong></span>
                <p>$description</p>
                <span class=\"yello\"><strong>$price</strong>
                <span class=\"yello\"><strong>$quantity</strong>
                </span> 
                </div>
            </div>
            <div>
      </div>
      ";
    }
}

function shipping_date()
{
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    $today = date('D M Y');
    $NewDate = date('D M Y', strtotime('+3 days'));
    echo "Confirmation de votre commande le $today . <br> Estimation de livraision $NewDate .";
}
function show_cart()
{

    foreach ($_SESSION['panier'] as $product) {
        $quantity = $product['quantity'];
        $img = $product['picture'];
        $name = $product['name'];
        $price = $product['price'];
        $description = $product['description_court'];
        $id = $product['id'];

        echo  "
        <div class=\"col-md-6 d-flex panier_card justify-content-around  mt-5 align-items-center\">
            <div class=\" panier_box\" style=\"background-image: url(./assets/img/" . $img . "\"); color:red;\"></div>
            <div class=\"panier_descp\">
                <span class=\"yello\" ><strong>$name</strong></span>
                <p>$description</p>
                <span class=\"yello\"><strong>$price</strong>

                <form action=\"./panier.php\" method=\"post\">
                <input type=\"number\" name=\"update_new_quantity\" min=\"1\" max=\"20\" value=\"$quantity\"/> 
                <input type=\"hidden\" name= \"modified_product_id\" value=\"$id\"/> 
                <button type=\"submit\"/><i class=\"fas fa-arrow-up\"></i> </button> 
                </form> 
                <form action=\"./panier.php\" method=\"post\">
                <input type=\"hidden\"  name=\"delete_product_by_id\" value=\"$id\"/>  
                <input type=\"submit\" value=\"x\"/> 
            </form>
                </span>
                
                </div>
            </div>
            <div>
      </div>
      ";
    }
}
function frais()
{
    $frais = 3;
    $result = 0;
    foreach ($_SESSION['panier'] as $product) {
        $result = $product['quantity'] * $frais;
        // quantiti plus prix plus frais 
    }
    return $result;
}

function show_cart_total()
{
    $_SESSION['panier'];
    $price = 0;
    foreach ($_SESSION['panier'] as $product) {
        $price += $product['price'] * $product['quantity'];
    }
    $price += frais(); 
    echo "<p class=\"total\">$price</p>";
}

function get_product_by_id($id)
{
    $products = get_products();
    foreach ($products as $product) {
        if ($id === $product['id'])
            return $product;
    }
    return false;
}
