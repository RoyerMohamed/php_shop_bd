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
function stock_info($id)
{
    $product = get_product_by_id($id);
    $stock_info =  $product['stock'];

    $stock = intval($product['stock']) > 1 ? "le stock est de $stock_info " : "Le produit est plus en stock ";

    return $stock;
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
        $stock = stock_info($product_id);
        echo  "<div class=\" categories_box\" style=\"
        background-image: url(./assets/img/" . $img . "\");
         color:red;
         background-position:top;
         \">
         <span class=\"yello\" ><strong>$name</strong></span>
         <p>$description</p>
         <p>$stock</p>
         <span class=\"yello fs-3 \"><strong>$price € </strong> 

         </span>
            <form class=\"w-50\" action=\"./produit.php\" method=\"post\">
            <button type=\"submit\" class=\"btn btn-warning\">en savoir plus </button>
            <input type=\"hidden\" name=\"product_id\" value=\"$product_id\"/> 
            </form> 
           
          </div>
          
          ";
    }
}
function add_to_cart($id)
{
    $product = get_product_by_id($id);
    // var_dump($_SESSION['panier']); 
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
        <div class=\"col-md-6 d-flex panier_card justify-content-between  mt-5 align-items-center\">
            <div class=\" panier_box\">
            <img src=\"./assets/img/" . $img . "\" alt=\"\" class=\"panier_img\">
            </div>
            <div class=\"panier_descp\">
                <span class=\"yello\" ><strong>$name</strong></span>
                <p>$description</p>
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
        $price = $product['prix'];
        $description = $product['description_court'];
        $id = $product['id'];


        echo  "
        <div class=\"col-md-6 d-flex panier_card justify-content-around  mt-5 align-items-center\">            
            <img src=\"./assets/img/" . $img . "\" alt=\"\" class=\"panier_img\">
            <div class=\"panier_descp\">
                <span class=\"yello\" ><strong>$name</strong></span>
                <p>$description</p>
                <span class=\"yello d-flex flex-column justify-content-between\"><strong>$price €</strong>

                <form action=\"./panier.php\" method=\"post\">
                    <div  class=\"pt-2\">
                        <label for=\"quantity\">Qantité</label>
                        <input type=\"number\" name=\"update_new_quantity\" min=\"1\" max=\"20\" value=\"$quantity\" class=\"quantity\"/> 
                        <input type=\"hidden\" name= \"modified_product_id\" value=\"$id\"/> 
                        <button type=\"submit\"/><i class=\"fas fa-arrow-up\"></i> </button> 
                    </div>
                </form> 


                <form action=\"./panier.php\" method=\"post\">
                    <div class=\"pt-2\">
                        <input type=\"hidden\"  name=\"delete_product_by_id\" value=\"$id\"/>  
                        <input class=\"btn btn-danger\" type=\"submit\" value=\"Supprimer\"/> 
                    </div>
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
        $price += $product['prix'] * $product['quantity'];
    }
    $price += frais();
    echo "<p class=\"total\">Votre panier est de $price €</p>";
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
    <h1 class=\"text-center pb-5\">Inscription <i class=\"fas fa-sign-in-alt\"></i></h1>
    
    <form class=\"\" action=\"connection.php\" method=\"POST\">

    <div class=\"row\">

    <div class=\"col mb-3\"> 
    <label for=\"nom_inscription\" class=\"form-label\">Nom</label>
    <input type=\"text\" class=\"form-control\" name=\"nom_inscription\" id=\"nom_inscription\" aria-describedby=\"emailHelp\">
</div>

<div class=\"col mb-3\">
    <label for=\"prenom_inscription\" class=\"form-label\">Prenom </label>
    <input type=\"text\" class=\"form-control\" name=\"prenom_inscription\" id=\"prenom_inscription\">
</div>
    </div>

    <div class=\"row\">


        <div class=\"col mb-3\">
            <label for=\"email_inscription\" class=\"form-label\">email </label>
            <input type=\"email\" class=\"form-control\" name=\"email_inscription\" id=\"email_inscription\">
        </div>

        <div class=\"col mb-3\">
            <label for=\"mot_de_passe_inscription\" class=\"form-label\">Mot de passe </label>
            <input type=\"password\" class=\"form-control\" name=\"mot_de_passe_inscription\" id=\"mot_de_passe_inscription\">
        </div>
    </div>


    <div class=\"col mb-3\">
    <label for=\"adresse\" class=\"form-label\">Adresse </label>
    <input type=\"text\" class=\"form-control\" name=\"adresse\" id=\"adresse\">
    </div>

<div class=\"col mb-3\">
    <label for=\"code_postal\" class=\"form-label\">code postal </label>
    <input type=\"text\" class=\"form-control\" name=\"code_postal\" id=\"code_postal\">
</div>
<div class=\"col mb-3\">
    <label for=\"ville\" class=\"form-label\">ville </label>
    <input type=\"text\" class=\"form-control\" name=\"ville\" id=\"ville\">
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
            var_dump(strlen($value) < 3 && strlen($value) > 30);
            echo '<script>alert(\'la longeur de votre' . $key . ' n\'est pas bonne ! \')</script>';
        }
    }

    // if ($user['mot_de_passe'] != null) {
    //     $uppercase = preg_match('@[A-Z]@', $user["mot_de_passe"]);
    //     $lowercase = preg_match('@[a-z]@', $user["mot_de_passe"]);
    //     if (!$lowercase || !$uppercase) {
    //         echo '<script>alert(\'Votre mot de passe ne remplis pas toute les conditions \')</script>';
    //         return;
    //     }
    // }

    add_user_infos($user); 

    $query = $db->prepare(
        'INSERT INTO clients (nom,prenom,mot_de_passe,email) 
        VALUES (:nom,:prenom,:mot_de_passe,:email ) '
    );


    $query->execute(array(
        "nom" => $user["nom"],
        "prenom" => $user["prenom"],
        "mot_de_passe" => password_hash($user["mot_de_passe"], PASSWORD_DEFAULT),
        "email" => $user["email"]
    ));



    echo "<script>alert(\"Vous ètes bien inscrit \")</script>";
}

function add_user_infos($user){
    $db = getConnection();

    
    $user_adress = $db->prepare(
      'INSERT INTO adresses (adresse, code_postal, ville) VALUES (:adresse, :code_postal, :ville); '
  );
    $user_adress->execute(array(
        "adresse" => $user["adresse"],
        "code_postal" => $user["code_postal"],
        "ville" => $user["ville"]  
      ));

}

function btn_validation()
{

    if (isset($_SESSION["user_info"]) && count($_SESSION['panier']) == 0) {
        echo '<script>alert(\'Votre panier est vide !\')</script>';
    } else if (isset($_SESSION["user_info"]) && count($_SESSION['panier']) >= 1) {
        echo "
        <form action=\"./panier.php\" class=\"col text-center\" method=\"post\">
        <input class=\"btn btn-danger\"  type=\"submit\" name=\"delete_panier\" value=\"vider le panier \" />
    </form>
        
        <form action=\"./validation.php\" class=\"col text-center\" method=\"post\">
        <input class=\"btn btn-primary\" type=\"submit\" name=\"validation_de_paiment\" value=\"valider votre commande\" />
    </form>";
    } else {
        echo "<form action=\"./connection.php\" class=\"col text-center\" method=\"post\">
                <input class=\"btn btn-primary\" type=\"submit\"  value=\"connectez-vous\" />
             </form>";
    }
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
        if (password_verify($_POST["mot_de_passe_conection"], $result["mot_de_passe"])) {
            $_SESSION["user_info"]  = array_splice($result, array_search("mot_de_passe", array_keys($result)), 1);
            array_push($_SESSION["user_info"], ["is_connected" => true]);
            echo '<script>alert(\'Vous êtes connecté !\')</script>';
        } else {
            echo '<script>alert(\'Mot de passe n\'est pas bon !\')</script>';
        }
    } else {
        echo '<script>alert(\'Email n\'est pas bon !\')</script>';
    };
    return false;
}

function Show_connection()
{
    echo "
    <form class=\"row  w-100 col-md-6 justify-content-center\" action=\"index.php\" method=\"POST\">
        <h1 class=\"text-center\">Connection <i class=\"fas fa-user\"></i></h1>

            <div class=\"mb-2\">
                <label for=\"email_conection\" class=\"form-label\">Email address</label>
                <input type=\"email\" class=\"form-control\" name=\"email_conection\" id=\"email_conection\" aria-describedby=\"emailHelp\">
            </div>

            <div class=\"mb-2\">
                <label for=\"mot_de_passe_conection\" class=\"form-label\">Password</label>
                <input type=\"password\" name=\"mot_de_passe_conection\" class=\"form-control\" id=\"mot_de_passe_conection\">
            </div>

            <div class=\" d-flex justify-content-center\">
                <button type=\"submit\" class=\" btn btn-primary w-25 fs-5\">connection </button>
            </div>

        </form>

    <div class=\"row text-center \">
        <h1 class=\"text-center pb-5\">Inscription <i class=\"fas fa-sign-in-alt\"></i></h1>
        <form action=\"inscription.php\" method=\"POST\">
        <input type=\"submit\" class=\"btn btn-danger w-50 fs-5\"value=\"Inscrivez-vous ici \">
        </form>
    </div>
    
    ";
}

function show_profil()
{
    echo "
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
 ";
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
function get_user_by_id($id)
{
    $db = getConnection();
    $result = $db->prepare('SELECT nom FROM clients WHERE id=:id');
    $result->execute(array("id" => $id));
    $result->fetch();
    return $result;
}

function log_out_user()
{
    session_unset();
    setcookie("PHPSESSID");
    echo "<script>alert('Vous avez bien été déconnecté !')</script>";
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


function uptate_information($data) {
    $db = getConnection();
    $result = $db->prepare('UPDATE clients SET nom = :nom, prenom = :prenom WHERE clients.id = :id');
    var_dump($data);
    $result->execute(array(
        "id" => $data['id'], 
        "nom"=> $data['update_nom'], 
        "prenom"=> $data['update_prenom']
    ));

    echo "<script>alert('Vos information ont bien été modifier !')</script>";

}
function uptate_passe($data) {
    $db = getConnection();
    $result = $db->prepare('UPDATE clients SET nom = :nom, prenom = :pronom WHERE clients.id = :id');
    $result->execute(array(
        "id" => $data['id'], 
        "nom"=> $data['update_nom'], 
        "prenom"=> $data['update_prenom']
    ));

    echo "<script>alert('Vos information ont bien été modifier !')</script>";

}
function uptate_adress($data) {
    $db = getConnection();
    $result = $db->prepare('UPDATE adresses SET adresse = :adress, code_postal = :code_postal , ville = :ville WHERE adresses.id = :id');
    $result->execute(array(
        "id" => $data['id'], 
        "adress"=> $data['update_adress'], 
        "code_postal"=> $data['update_code_postal'],
        "ville"=> $data['update_ville'],  
    ));

    echo "<script>alert('Votre adresse bien été modifier !')</script>";
}


function decript_pass($id){
   var_dump(get_user_by_id($id)) ; 
}