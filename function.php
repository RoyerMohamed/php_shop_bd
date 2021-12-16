<?php
//add desp_cour
//optimise pas de boucle pour les show

ini_set('display_errors', 1);

/* diplay functions*/


/**/
function show_single_product($id)
{
    $products = mes_produit();

    foreach ($products as $product) {
        $saveur = $product['saveur'];
        $img = $product['picture'];
        $Effets = $product['effets'];
        $name = $product['name'];
        $price = $product['prix'];
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
    $products = mes_produit();
    foreach ($products as $product) {

        $img = $product['picture'];
        $name = $product['name'];
        $price = $product['prix'];
        $description = $product['description_court'];
        $product_id = $product['id'];

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
    $db = getConnection();
    foreach ($_SESSION['panier'] as $value) {
        $result = $db->prepare('INSERT INTO commandes (numero,date_commande,prix ) VALUES (:numero,:date_commande,:prix ) ');
        $result->execute(array(
            'numero' => rand(0, 9999999),
            'date_commande' => date('D M Y'),
            'prix' => $value['prix']
        ));
    }
    $_SESSION['panier'] = array();
}

function show_validation()
{
    foreach ($_SESSION['panier'] as $product) {
        $quantity = $product['quantity'];
        $img = $product['picture'];
        $name = $product['name'];
        $description = $product['description_court'];
        echo  "
        <div class=\"col-md-6 d-flex panier_card justify-content-around  mt-5 align-items-center\">
            <div class=\" panier_box\" style=\"background-image: url(./assets/img/" . $img . "\"); color:red;\"></div>
            <div class=\"panier_descp\">
                <span class=\"yello\" ><strong>$name</strong></span>
                <p>$description</p>
                <p> X $quantity</p>
                <p> X $quantity</p>

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
    $db = getConnection();
    $result = $db->prepare('SELECT * FROM articles WHERE id = :id');
    $result->execute(array(
        'id' => $id
    ));
    return $result->fetch();
}

function getConnection()
{
    try {
        $db = new PDO(
            'mysql:host=localhost;dbname=shop;charset=utf8',
            'root',
            'root',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC)
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}

function mes_produit()
{
    $db = getConnection();
    $query = $db->query('SELECT * FROM articles');
    $products = $query->fetchAll();
    return $products;
}
function show_inscription()

{
    //ajoue de
    echo "
    <form action=\"connection.php\" method=\"POST\">
  <div class=\"mb-3\"> 
    <label for=\"nom_inscription\" class=\"form-label\">Nom</label>
    <input type=\"text\" class=\"form-control\" name=\"nom_inscription\" id=\"nom_inscription\" aria-describedby=\"emailHelp\">
  </div>
  <div class=\"mb-3\">
    <label for=\"prenom_inscription\" class=\"form-label\">Prenom </label>
    <input type=\"text\" class=\"form-control\" name=\"prenom_inscription\" id=\"prenom_inscription\">
  </div>
  <div class=\"mb-3\">
  <label for=\"email_inscription\" class=\"form-label\">email </label>
  <input type=\"email\" class=\"form-control\" name=\"email_inscription\" id=\"email_inscription\">
    </div>
    <div class=\"mb-3\">
    <label for=\"mot_de_passe_inscription\" class=\"form-label\">Mot de passe </label>
    <input type=\"password\" class=\"form-control\" name=\"mot_de_passe_inscription\" id=\"mot_de_passe_inscription\">
    </div>
    <input type=\"submit\" class=\"btn btn-primary\"value=\"Submit\">
    </form>
 ";
}

function add_user($user)
{
    $db = getConnection();

    foreach ($user as $key => $value) {
        if (strlen($value) < 3 && strlen($value)) {
            var_dump(strlen($value) < 3 && strlen($value) > 30 );
            echo '<script>alert(\'la longeur de votre' . $key . ' n\'est pas bonne ! \')</script>';
        }
    }

        if ($user['mot_de_passe'] != null) {
            $uppercase = preg_match('@[A-Z]@', $user["mot_de_passe"]);
            $lowercase = preg_match('@[a-z]@', $user["mot_de_passe"]);
            if (!$lowercase || !$uppercase ) {
                echo '<script>alert(\'Votre mot de passe ne remplis pas toute les conditions \')</script>';
                return;
            }
        }  

    $query = $db->prepare(
        'INSERT INTO clients (nom,prenom,mot_de_passe,email) 
        VALUES (:nom,:prenom,:mot_de_passe,:email ) '
    );

    $query->execute(array(
        "nom" => $user["nom"],
        "prenom" => $user["prenom"],
        "mot_de_passe" => $user["mot_de_passe"],
        "email" => $user["email"]
    ));

   echo "<script>alert(\"Vous ètes bien inscrit \")</script>";
}

function user_connection()
{

    $db = getConnection();
    $clients = $db->prepare('SELECT * FROM clients WHERE email=:email');
    $clients->execute(array(
        "email" =>  $_POST['email_conection']
    ));
    $result = $clients->fetch();
    if ($result) {
        //var_dump($result);
        if ($result["mot_de_passe"] === $_POST["mot_de_passe_conection"]) {
            $_SESSION["user_info"]  = array_splice($result, array_search("mot_de_passe", array_keys($result)), 1);
           var_dump($_SESSION["user_info"]);
            echo '<script>alert(\'Vous êtes connecté !\')</script>';
        } else {
            echo '<script>alert(\'Mot de passe n\'est pas bon  !\')</script>';
        }
    } else {
        echo '<script>alert(\'Email n\'est pas bon !\')</script>';
    };
    return false;
}

function Show_connection()
{
    echo "
    <h1>connecté vous </h1>
    <div class=\"container \">
        <form action=\"index.php\" method=\"POST\">
            <div class=\"mb-3\">
                <label for=\"email_conection\" class=\"form-label\">Email address</label>
                <input type=\"email\" class=\"form-control\" name=\"email_conection\" id=\"email_conection\" aria-describedby=\"emailHelp\">
            </div>
            <div class=\"mb-3\">
                <label for=\"mot_de_passe_conection\" class=\"form-label\">Password</label>
                <input type=\"password\" name=\"mot_de_passe_conection\" class=\"form-control\" id=\"mot_de_passe_conection\">
            </div>
            <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
        </form>
    </div>";
}

function show_profil()
{
    echo "
    <h1>mon profil </h1>
    <div class=\"container \">
        <form action=\"index.php\" methode=\"POST\">
            <div class=\"mb-3\">
                <label for=\"exampleInputEmail1\" class=\"form-label\">Email address</label>
                <input type=\"email\" class=\"form-control\" id=\"exampleInputEmail1\" aria-describedby=\"emailHelp\">
                <div id=\"emailHelp\" class=\"form-text\">We'll never share your email with anyone else.</div>
            </div>
            <div class=\"mb-3\">
                <label for=\"exampleInputPassword1\" class=\"form-label\">Password</label>
                <input type=\"password\" class=\"form-control\" id=\"exampleInputPassword1\">
            </div>
        
            <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
        </form>
    </div>";
}

function show_multiple_orders()
{
    $orders = get_all_orders();
    foreach ($orders as $order) {
        # code...
        echo " <div class=\"commandes\">
        commande info 
        </div>";
    }
    // 
}
function get_all_orders()
{
    $db = getConnection();
    $query = $db->query('SELECT * FROM commandes');
    $products = $query->fetchAll();
    return $products;
}

function show_single_orders($id)
{
    $order = get_order_by_id($id);
    foreach ($order as $value) {
        # code...
        echo " <div class=\"commandes\">
       single commande info 
        </div>";
    }
    // 
}
function get_order_by_id($id)
{

    $db = getConnection();
    $result = $db->prepare('SELECT * FROM commandes WHERE id=:id');
    $result->execute(array("id" => $id));
    $result->fetch();

    return $result;
}








function check_passe($user)
{
    foreach ($user as $key => $value) {
        if (strlen($value) < 3 || strlen($value) > 30) {
            //regex
            echo '<script>alert(\'la longeur de votre' . $key . ' n\'est pas bonne ! \')</script>';
        }
    }
}
