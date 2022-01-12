<?php
//add desp_cour
//optimise pas de boucle pour les show

ini_set('display_errors', 1);

/* diplay functions*/


/**/
function show_single_product($id)
{
    $product= get_article_by_id(intval($id));

        echo"<pre>";
    var_dump($product['id']);
    echo"</pre>";
        $saveur = $product['saveur'];
        $img = $product['picture'];
        $Effets = $product['effets'];
        $name = $product['name'];
        $price = $product['prix'];
        $description = $product['description'];
        $product_id = $product['id'];

       
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
                       <input type=\"hidden\" name=\"add_to_cart\" value=$product_id/> 
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
function add_to_cart($product_id)
{
   $product= get_article_by_id(intval($product_id)); 
    $product['quantity'] =isset($_POST['update_new_quantity']) ? intval($_POST['update_new_quantity']) : 1;   
   // var_dump($product);
    foreach ($_SESSION['panier'] as  $value) {
        if ($product['id'] === $value['id']) {
            echo '<script>alert(\'Le produit est deja présant !\')</script>';
            return; 
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
function save_ordre()
{
    $db = getConnection();
    $result = $db->prepare('INSERT INTO commandes (numero,date_commande,prix,id_client ) VALUES (:numero,:date_commande,:prix,:id_client ) ');
    $result->execute(array(
        'numero' => rand(1000000, 9999999),
        'date_commande' => date('D M Y'),
        'prix' => calculate_total_price(),
        'id_client' => $_SESSION["user_info"][0],
    ));
    $id = $db->lastInsertId();

    $result = $db->prepare('INSERT INTO commandes_articles (id_commande,id_articles, quantite ) VALUES (:id_commande,:id_articles ,:quantite) ');
    foreach ($_SESSION['panier'] as $article) {
        $result->execute(array(
            'id_commande' => $id,
            'id_articles' => $article['id'],
            'quantite' => $article['quantity']
        ));
    }
    $_SESSION['panier'] = array();
}

function get_article_by_id($id){
    $db = getConnection();
    $clients = $db->prepare('SELECT * FROM articles WHERE id=:id');
    $clients->execute(array(
        "id" =>  $id
    ));
    return $clients->fetch();
}
function show_validation_card(){

    foreach ($_SESSION['panier'] as $key => $value) {

     
        $quantity = $_SESSION['panier'][$key]['quantity'];
        $img = $_SESSION['panier'][$key]['picture'];
        $name = $_SESSION['panier'][$key]['name'];
        $description = $_SESSION['panier'][$key]['description_court'];
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
        # code...
    }

    for ($i = 0 ; count($_SESSION['panier']) > $i ; $i++){
         
    }
    }


function shipping_date()
{
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    $order_date = date('D M Y');
    $order_delivery_date = date('D M Y', strtotime('+3 days'));
   $product_price= product_price(); 
   $frais = frais();
   $calculate_total_price = calculate_total_price();     
    return "
    Le total de votre commande est de $product_price € , qui compte $frais € de frais de ports <br>
    Pour un total de $calculate_total_price €. <br>
    Nous avons pris en compte votre commande passé le $order_date et nous estimons une livration au $order_delivery_date.
     <br> Merci davoir passer commande ";
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
function calculate_total_price()
{
    return frais() + product_price();
}
function frais()
{
    $frais = 3;
    $result = 0;
    foreach ($_SESSION['panier'] as $product) {
        $result = $product['quantity'] * $frais;
    }
    return $result;
}

function product_price()
{
    $_SESSION['panier'];
    $price = 0;
    foreach ($_SESSION['panier'] as $product) {
        $price += $product['prix'] * $product['quantity'];
    }
    return $price;
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

    if (check_passe($user['mot_de_passe']) && checkInputsLenght()) {

        $db = getConnection();

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

        $id = $db->lastInsertId();

        $query = $db->prepare(
            'INSERT INTO adresses (id_client,adresse,code_postal ,ville) 
            VALUES (:id_client,:adresse,:code_postal,:ville) '
        );

        $query->execute(array(
            "id_client" =>  $id,
            "adresse" => $user["adresse"],
            "code_postal" => $user["code_postal"],
            "ville" => $user["ville"]
        ));

        echo "<script>alert(\"Vous ètes bien inscrit ! \")</script>";
        return;
    } else {
        echo "<script>alert(\"Votre mot de passe ne respect pas les conditions  \")</script>";
        return;
    }
}

function checkInputsLenght()
{
    $inputsLenghtOk = true;

    if (strlen($_POST['nom_inscription']) > 25 || strlen($_POST['nom_inscription']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la longeur de votre nom n\'est pas bonne ! \')</script>';
    }
    if (strlen($_POST['prenom_inscription']) > 25 || strlen($_POST['prenom_inscription']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la longeur de votre prenom n\'est pas bonne ! \')</script>';
    }
    if (strlen($_POST['mot_de_passe_inscription']) > 25 || strlen($_POST['mot_de_passe_inscription']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la longeur de votre mot de passe n\'est pas bonne ! \')</script>';
    }
    if (strlen($_POST['adresse']) > 25 || strlen($_POST['adresse']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la forme de votre adresse n\'est pas bonne ! \')</script>';
    }
    if (strlen($_POST['code_postal']) > 25 || strlen($_POST['code_postal']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la longeur de votre code postal n\'est pas bonne ! \')</script>';
    }
    if (strlen($_POST['ville']) > 25 || strlen($_POST['ville']) < 3) {
        $inputsLenghtOk = false;
        echo '<script>alert(\'la longeur du chang ville n\'est pas bonne ! \')</script>';
    }
    return $inputsLenghtOk;
}

function btn_validation()
{
    $panier = $_SESSION['panier'];

    if (isset($_SESSION["user_info"]) && count($_SESSION['panier']) == 0) {
        echo '<script>alert(\'Votre panier est vide !\')</script>';
    } else if (isset($_SESSION["user_info"]) && count($_SESSION['panier']) >= 1) {
        echo "
        <form action=\"./panier.php\" class=\"col text-center\" method=\"post\">
        <input class=\"btn btn-danger\"  type=\"submit\" name=\"delete_panier\" value=\"vider le panier \" />
    </form>
        
        <form action=\"./validation.php\" class=\"col text-center\" method=\"post\">
        <input class=\"btn btn-primary\" type=\"submit\" name=\"validation_de_paiment\" value=\"valider votre commande\" />
        <input type=\"hidden\" value=\"\">

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
//innerjoin 
function get_all_orders_by_user()
{
    ////////////////
    $db = getConnection();
    $result = $db->prepare('SELECT * FROM clients WHERE id = :id INNER JOIN commandes ON commandes.id_client = clients.id');
    $result->execute(array("id" => intval($_SESSION["user_info"][0])));
    return  $result->fetchAll();
}
function Show_connection()
{
    echo "
    <form class=\"row col-md-6 justify-content-center\" action=\"index.php\" method=\"POST\">
        <h1 class=\" d-flex flex-column-reverse align-items-center \">Connection <i class=\"fas fa-user\"></i></h1>

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
        <h1 class=\" d-flex flex-column-reverse align-items-center pb-5\">Inscription <i class=\"fas fa-sign-in-alt\"></i></h1>
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


function get_all_orders()
{
    $id = intval($_SESSION["user_info"][0]);
    $db = getConnection();
    $result = $db->prepare('SELECT * FROM clients WHERE id = ? INNER JOIN commandes ON commandes.id_client = clients.id');
    $result->execute(array("id" => $id));
    $result->fetch();
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
    $result = $db->prepare('SELECT * FROM commandes WHERE id = :id');
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

function check_passe($password)
{
    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$!%?/&])(?=\S+$).{8,15}$^";
    return preg_match($regex, $password);
}

function uptate_information($data)
{
    $db = getConnection();
    $result = $db->prepare('UPDATE clients SET nom = :nom, prenom = :prenom WHERE id = :id');
    $result->execute(array(
        "id" => $data['id'],
        "nom" => $data['update_nom'],
        "prenom" => $data['update_prenom']
    ));

    echo "<script>alert('Vos information ont bien été modifier !')</script>";
}


function uptate_passe()
{
    $db = getConnection();
    //$user = get_user_by_id(intval($_SESSION["user_info"][0]));

    $query = $db->query('SELECT mot_de_passe FROM clients WHERE id = :id');
    $query->execute(array("id" => $_SESSION["user_info"][0]));
    $old_pass_data_base = $query->fetchAll();
    if (password_verify(strip_tags($_POST['old_pass']), $old_pass_data_base[0]["mot_de_passe"])) {

        if (check_passe($_POST['new_pass'])) {
            $result = $db->prepare('UPDATE clients SET mot_de_passe = :mot_de_passe  WHERE id = :id');
            $result->execute(array(
                "id" => intval($_SESSION["user_info"][0]),
                "mot_de_passe" => password_hash(strip_tags($_POST['new_pass']), PASSWORD_DEFAULT),
            ));
            echo "<script>alert('Vos information ont bien été modifier !')</script>";
            return;
        } else {
            echo "<script>alert('Sécuriter de votre mot de passe est insuffisante !')</script>";
            return;
        }
    } else {
        echo "<script>alert('Votre mot de passe ne corespond pas  !')</script>";
        return;
    }
}


function uptate_adress()
{
    $db = getConnection();
    $result = $db->prepare('UPDATE adresses SET adresse = :adress, code_postal = :code_postal , ville = :ville WHERE id_client = :id');
    $result->execute(array(
        "id" => intval($_SESSION["user_info"][0]),
        "adress" => $_POST['update_adress'],
        "code_postal" => $_POST['update_code_postal'],
        "ville" => $_POST['update_ville'],
    ));
    echo "je suis la aussi ";
    echo "<script>alert('Votre adresse bien été modifier !')</script>";
}

function show_uptate_adress($currentPage, $titre)
{

    return "
    <div class=\"col-md-3   d-flex flex-column text-center \">
    <i class=\"fas fa-home pb-4\" style=\"font-size: 5rem;\"></i>

    <h4>
    $titre
    </h4>
    <form action=\"./" . $currentPage . "\" method=\"post\">
        <div class=\"d-flex flex-column text-center pb-3\">
            <label for=\"update_adress\">modifier votre adresse :</label>
            <input type=\"text\" name=\"update_adress\" id=\"update_adress\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex flex-column text-center pb-3\">
            <label for=\"update_code_postal\">modifier votre code postal :</label>
            <input type=\"text\" name=\"update_code_postal\" id=\"update_code_postal\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex flex-column text-center pb-3\">
            <label for=\"update_ville\">modifier votre ville :</label>
            <input type=\"text\" name=\"update_ville\" id=\"update_ville\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex w-50 mt-3 flex-column text-center pb-3\">
            <input type=\"submit\" class=\"btn btn-primary\" value=\"Valider\">
            <input type=\"hidden\" >
        </div>
    </form>
    </div>";
}

function show_uptate_pass($currentPage)
{

    echo "
    <div class=\"col-md-3 d-flex flex-column text-center \">
    <i class=\"fas fa-key pb-4  \" style=\"font-size: 5rem;\"></i>
    <h4>
        Modifier mon mot de passe
    </h4>
    <form action=\"./" . $currentPage . "\" method=\"post\">

   <div class=\"d-flex flex-column text-center pb-3\">
   <label for=\"old_pass\">ancien votre mot de pass :</label>
            <input type=\"text\" name=\"old_pass\" id=\"old_pass\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex flex-column text-center pb-3\">
   <label for=\"new_pass\">ancien votre mot de pass :</label>
            <input type=\"text\" name=\"new_pass\" id=\"new_pass\">
            <input type=\"hidden\" >
        </div>

        <div class=\"d-flex w-50 mt-3 flex-column text-center pb-3\">
            <input type=\"submit\" class=\"btn btn-primary\" value=\"Valider\">
            <input type=\"hidden\">
        </div>
    </form>

    </div>";
}
function show_uptate_information($currentPage, $titre)
{

    return "
    <div class=\"col-md-3 d-flex flex-column text-center \">
    <i class=\"fas fa-users pb-4  \" style=\"font-size: 5rem;\"></i>
    <h4>
        $titre
    </h4>
    <form action=\"./" . $currentPage . "\" method=\"post\">
        <div class=\"d-flex flex-column text-center pb-3\">
            <label for=\"update_nom\">modifier votre nom :</label>
            <input type=\"text\" name=\"update_nom\" id=\"update_nom\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex flex-column text-center pb-3\">
            <label for=\"update_prenom\">modifier votre prenom :</label>
            <input type=\"text\" name=\"update_prenom\" id=\"update_prenom\">
            <input type=\"hidden\" >
        </div>
        <div class=\"d-flex w-50 mt-3 flex-column text-center pb-3\">
            <input type=\"submit\" class=\"btn btn-primary\" value=\"Valider\">
            <input type=\"hidden\">
        </div>
    </form>
    </div>";
}


function decript_pass($id)
{
}

function checkEmptyFields()
{

    $emptyFieldsFound = false;

    foreach ($_POST as $field) {
        if (empty($field)) {
            $emptyFieldsFound = true;
        }
    }

    return $emptyFieldsFound;
}


function show_validation()
{

    $show_validation_card = show_validation_card();
    $show_uptate_information =  show_uptate_information("validation.php", "choix des coordonnées");
    $show_uptate_adress = show_uptate_adress("validation.php", "Choix de l'edresse de livration");
    $shipping_date=shipping_date();
    $product_price = product_price(); 
    $frais = frais(); 
    $calculate_total_price = calculate_total_price();

    return "
    
    <section class=\"container w-50   flex-wrap validation \">

  <div class=\" d-flex justify-content-between flex-wrap\">
    <span>total de vos achat est de :  $product_price €</span>
    <span>total de frais de port : $frais €</span>
    <span>total à payer : $calculate_total_price €</span>
  </div>

  <div class=\" d-flex justify-content-between flex-wrap\">
    $show_validation_card 
  </div>

  <div class=\"info_validation \"></div>

  <div class=\"row text-center\">
    $show_uptate_adress
    $show_uptate_information
  </div>

  <div class=\"validation-btn\">

    

    <div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
      <div class=\"modal-dialog\">
        <div class=\"modal-content\">
          <div class=\"modal-header\">
            <h5 class=\"modal-title\" id=\"exampleModalLabel\"></h5>
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
          </div>
          <div class=\"modal-body\">
             $shipping_date  </div>
          <div class=\"modal-footer\">
            <form action=\"/index.php\" method=\"post\">
              <input type=\"submit\" class=\"btn btn-primary\" value=\"Valider\">
              <input type=\"hidden\" name=\"validation_de_commande\">
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

</section>
    
    ";
}


function show_commandes(){
    foreach (get_all_orders_by_user() as $key => $value) {
        var_dump($value);
        $num_commande = $value['numero'];
        $date_commande = $value['date_commande'] ; 
        $prix = $value['prix']; 
        echo "  
          <tr>
            <th scope=\"row\">2</th>
            <td>$num_commande</td>
            <td>$date_commande</td>
            <td>$prix €</td>
            <td>
            <form action=\"details_commande.php\" method=\"post\">
                        <input type=\"hidden\" name=\"orderId\" value=\"" . htmlspecialchars($value["id"]) ."\">
                        <input type=\"hidden\" name=\"orderNumber\" value=\"" . htmlspecialchars($num_commande) . "\">
                        <input type=\"hidden\" name=\"orderTotal\" value=\"" . htmlspecialchars( $prix ) . "\">
                        <input type=\"hidden\" name=\"orderDate\" value=\"" . htmlspecialchars($date_commande) . "\">
                        <button type=\"submit\" class=\"btn w-50 btn-secondary\">
                        <i class=\"fas fa-arrow-right\"></i>
                        </button>                   
                         </form>
           
            </td>
          </tr>
          " ; 
        }

}

