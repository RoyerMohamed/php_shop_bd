<?php session_start();
 $is_connected = false; 
if (isset($_SESSION["is_connected"])) {
 $is_connected = true ; 
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Shop</title>
</head>

<body>

    <header class="d-flex container justify-content-between pt-3 pb-5">
        <div class="logo">
            <img src="./assets/img/logo.png" alt="">
        </div>

        <nav>
            <ul class="nav ">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="panier.php">Panier</a>
                </li>

                <li class="<?php echo  $is_connected ? "d-none" :  "nav-item" ?>">
                    <a class="nav-link" href="connection.php"> Connection / Inscription </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php"><?php echo  $is_connected ?  "mon compte": ""  ?></a>
                </li>
                <li class="nav-item">
                    <form action="index.php" method="POST">
                        <input type="submit" class="nav-link disconect" value="<?php echo  $is_connected ?  "déconnection" : "" ?>">
                        <input type="hidden" name="log_out_user" value="" id="log_out_user">
                    </form>
                </li>

                <li class="mt-2  <?php echo  $is_connected ?  "nav-item" : "d-none" ?>">
                    <span class=""> </span>
                </li>



            </ul>

        </nav>
    </header>