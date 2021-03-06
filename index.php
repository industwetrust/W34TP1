<?php

//rechercher info sur mysqli_prepare stmt  mysqli::prepare(string $query)

    
    include("PHPMailer_v5.1/class.phpmailer.php");
    include("PHPMailer_v5.1/class.smtp.php");
    
    include("Includes/functionsAndClasses.php");
    include("contact_form/email_validation.php");

    
    session_start();
        $SECONDS_IN_A_DAY = 60*60*24;
       if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }
    
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "tpw34";
    
    $PRODUCT_CATEOGORIES_IMG_PATH = "Img/Categories/";
    $PRODUCT_IMGS_PATH = "Img/Products/";
    

    
    if (isset($_GET["page"]) && $_GET["page"] == "registrer") { // La création de cookie doit se faire avant tout output au client.
        if (empty($_POST["txtUsername"]) || empty($_POST["txtPassword"]) || empty($_POST["txtFirstname"]) || empty($_POST["txtLastname"]) || empty($_POST["txtPhone"])) {
            $_SESSION["TryRegisterResult"] = "MissingInfos";
        }
        else {
            $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

            if ($mySqli->query("SELECT * FROM Customers WHERE Username = '" . $_POST["txtUsername"] . "'")->num_rows > 0) {
                $_SESSION["TryRegisterResult"] = "UsernameTaken";
            }
            else if ($mySqli->query("SELECT * FROM Customers WHERE Email='" . $_POST["txtemail"] . "'")->num_rows > 0) {
                $_SESSION["TryRegisterResult"] = "EmailTaken";
            }
            
            else {
                $mySqli->query("INSERT INTO Customers (Username, Password, Firstname, Lastname, Phone, Email, RegisterDate) VALUES ('" .
                        $_POST["txtUsername"] .  "', '" .
                        md5($_POST["txtPassword"]) .  "', '" .
                        $_POST["txtFirstname"] . "', '" .
                        $_POST["txtLastname"] .  "', '" .
                        $_POST["txtPhone"] . "', '".
                        $_POST["txtemail"]."', '".
                        date("Y-m-d H:i:s")."')");
                if ($mySqli->affected_rows == 1) {
                    setcookie("username", $_POST["txtUsername"], time() + $SECONDS_IN_A_DAY * 90);
                    $_SESSION["login"]= $_POST["txtUsername"];
                    $_SESSION["TryRegisterResult"] = "Success";
                }
                else {
                    $_SESSION["TryRegisterResult"] = "OtherSqlError";
                }
            }
        }
    }
    
    if (isset($_GET["page"]) && $_GET["page"] == "login"){
        if (empty($_POST["txtUsername"]) || empty($_POST["txtPassword"]) ) {
            $_SESSION["TryRegisterResult"] = "MissingInfos";
        }
        else{
            $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
            $nom =$_POST["txtUsername"];
            $pass = md5($_POST["txtPassword"]);
            $query = "SELECT * FROM customers WHERE Username =  '". $nom. "' AND PASSWORD =  '". $pass."'";
            $result = $mySqli->query($query);
            if($result->num_rows ==1){
                //L'usager est Trouvé
                $ligne = $result->fetch_assoc();

                $_SESSION["login"] = $ligne["Username"];
                $_SESSION["TryRegisterResult"] = "Success";
            }
            else {
                $_SESSION["TryRegisterResult"] = "Erreur";
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Pablo Chocolatier</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Pablo Aguilar-Lliguin et Mickael Bergeron Néron">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>


        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/theme.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/skins/tango/skin.css" />
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
        <style type="text/css">
            b{
                font-family: 'Open Sans', sans-serif;
                font-weight: 800;
                font-size: 13px;
            }
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>

        <script src="js/bootstrap.js"></script>
        <script src="js/superfish.js"></script>
        <script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.js"></script>
        <script type="text/javascript" src="js/jquery.tweet.js"></script>
        <script type="text/javascript" src="js/myscript.js"></script>
        <script src="http://jquery.bassistance.de/validate/jquery.validate.js"></script>

        
        <link href="css/Products.css" rel="stylesheet">
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->    
    </head>

    <body onload="initialize()">
        <!--header-->
        <div class="header">
            <div class="wrap">
                <div class="navbar navbar_ clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="span4">
                                <br />
                                <div class="logo"><a href="index.php"><img src="img/logopablo.jpg" alt="" /></a></div>                        
                            </div>
                            <div class="span8">
                                <div class="follow_us">
                                    <ul>
                                         <?php
                                            if(isset($_SESSION["nom"]) || isset($_SESSION["login"])){
                                                if (isset($_SESSION["nom"]))
                                                {
                                                    echo "<li> Bonjour, <b>".$_SESSION["nom"]."</b></li>";
                                                }
                                                
                                                if (isset($_SESSION["login"]))
                                                {
                                                    echo "<li> Bonjour, <b>".$_SESSION["login"]."</b></li>";
                                                }
                                                
                                                echo " <br />deconnecter: <li><a class='delicious' href='index.php?page=sortir' >Delicious</a></li>";
                                            }
                                            else{
                                                echo "<li>Se connecter: </a></li>";
                                                echo "<li><a class='delicious modal_trigger' href='#modal' >Delicious</a></li>";
                                            }
                                            
                                            ?>
                                    </ul>
                                </div>
                                <nav id="main_menu">
                                    <div class="menu_wrap">
                                        <ul class="nav sf-menu">
                                            <li class="current"><a href="index.php">Accueil</a></li>
                                            <li><a href="index.php?page=about">À propos</a></li>
                                            <li class="sub-menu">
                                                <a href="index.php?page=Produits">Produits</a>
                                            </li>
                                            <?php 
                                                if(isset($_SESSION["login"])){
                                                    echo "<li class='sub-menu'><a href='javascript:{}'>Clients</a>";
                                                    echo "<ul><li><a href='index.php?page=clients'>Profile</a></li>";
                                                    echo "<li><a href='index.php?page=adress'>Adresses</a></li>";
                                                    echo "<li><a href='index.php?page=anciennes'>Anciennes Comandes</a></li></ul></li>";
                                                    
                                                }
                                                if(isset($_SESSION["nom"])){ ?>
                                                    <li class="sub-menu"><a href='javascript:{}'>Administrer</a>
                                                        <ul>
                                                            <li><a href="index.php?page=ManageComandes"><span>-</span>Nouvelles Commandes</a></li> 
                                                            <li><a href="index.php?page=GestionCategoriesProd"><span>-</span>Categories de produit</a></li> 
                                                            <li><a href="index.php?page=GestionProduits"><span>-</span>Produits</a></li> 
                                                            <li><a href="index.php?page=GestionProduitParCat"><span>-</span>Produit par catégories</a></li>
                                                            <li><a href="index.php?page=ArchiveComandes"><span>-</span>Anncienes Comandes</a></li> 
                                                        </ul>
                                                    </li>
                                            <?php } ?>
                                            <li class="sub-menu"><a href="index.php?page=contacts">Contactez-nous</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div style='background-image:url("Img/Cart.png"); float:right; margin-bottom:4px; 
                                 height:48px; width:48px; text-align:center;'>
                                    <a href='index.php?page=Panier' style='color:#060; font-size:18px; position:relative; 
                                       top:10px;'><?= $_SESSION["Basket"]->GetDiffProductCount() ?> </a>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>    
        </div>
        
        <!--//header-->    

        <!--page_container-->
        <div class="page_container">
            <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
                switch ($page) {
                    case "login"                  : include("Includes/login/login.php");            break;
                    case "users"                  : include("Includes/users.php");                  break;
                    case "registrer" :              include("Includes/login/registrer.php");        break;
                    case "sortir" :                 include("Includes/login/sortir.php");           break;
                    case "about" :                  include("Includes/about.php");                  break;
                    case "contacts" :               include("contact_form/contacts.php");           break;
                    case "Produits" :               include("Includes/Products.php");               break;
                    case "GestionCategoriesProd" :  include("ADMINWonka/ManageProdCategories.php"); break;
                    case "GestionProduits" :        include("ADMINWonka/ManageProducts.php");       break;
                    case "GestionProduitParCat" :   include("ADMINWonka/ManageProductsByCat.php");  break;
                    case "Panier" :                 include("Includes/ViewDec.php");                break;
                    case "AjouterCommande" :        include("Includes/AddOrderToDB.php");           break;
                    case "clients":                 include("Includes/clients.php");                break;
                    case "adress":                  include("Includes/adresse.php");                break;
                    case "anciennes":               include("Includes/anciennes.php");              break;
                    case "ManageComandes":          include("ADMINWonka/ManageComandes.php");       break;
                    case "ArchiveComandes":         include("ADMINWonka/ArchiveComandes.php");      break;
                    
                    default :                       include("Includes/homepage.php");               break;
                }
            } else //dans le cas ou l'url ne contient pas de param 'page'
                include("Includes/home.php");
            ?>
        </div>
        <!--//page_container-->

        <!--footer-->
        <div id="footer">
            <div class="wrap">
                <div class="container">
                    <div class="row">
                        <div class="span4">
                            <h2 class="title">Question?</h2>
                            <a name="question"/>
                            
                            <?php
                            if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"]))
                            {
                                if($_POST["email"] && !ValidateEmail($_POST["email"]))
                                {
                                echo "<div style='color:red; '>SVP entrez un courriel valide</div>";
                                }
                                else
                                {
                                    $mail             = new PHPMailer();
                                    $mail->IsSMTP();
                                    $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                                    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
                                    $mail->Port       = 465;                   // set the SMTP port

                                    $mail->Username   = "csharp1374@gmail.com";  // GMAIL username
                                    $mail->Password   = "jaime la peinture";            // GMAIL password

                                    $mail->From       = $_POST["email"];
                                    $mail->FromName   = $_POST["name"];
                                    $mail->Subject    = "test aburrido";
                                    $mail->AltBody    = $_POST["message"]; //Text Body
                                    $mail->WordWrap   = 50; // set word wrap

                                    $mail->MsgHTML($_POST["message"]);

                                    $mail->AddReplyTo($_POST["email"]);
                                    $mail->AddAddress("csharp1374@gmail.com"); //addresse d'envoi du courriel

                                    $mail->IsHTML(true); // send as HTML

                                    if(!$mail->Send()) {
                                      echo "Mailer Error: " . $mail->ErrorInfo;
                                    } else {
                                      echo "<div style='color:red; '>Question envoyée! Nous repondrons le plus tôt possible</div>";
                                    }
                                }
                            }
                            ?>
                            <form action="index.php#question" method="post">
                                <input class="span3" type="text" name="name" id="name" value="Nom" onFocus="if (this.value == 'Name')
                                            this.value = '';" onBlur="if (this.value == '')
                                                        this.value = 'Name';" />
                                <input class="span3" type="text" name="email" id="email" value="Courriel" onFocus="if (this.value == 'Email')
                                            this.value = '';" onBlur="if (this.value == '')
                                                        this.value = 'Email';" />
                                <textarea name="message" id="message" class="span3" onFocus="if (this.value == 'Message')
                                            this.value = '';" onBlur="if (this.value == '')
                                                        this.value = 'Message';" >Message</textarea>
                                <div class="clear"></div>
                                <input type="reset" class="btn dark_btn" value="Effacer" />
                                <input type="submit" class="btn send_btn" value="Envoyer!" />
                                <div class="clear"></div>
                            </form>
                        </div> 
                        <div class="span4">
                            <h2 class="title">Opinions</h2>
                            <ul>
                                <li>
                                    <span class="testimonials_arrow"></span>J'adore ses chocolats!
                                    <div class="clear"></div>
                                    <div class="author">Willy Wonka, Company inc.</div>
                                </li>
                                <li>
                                    <span class="testimonials_arrow"></span>Le chocolat aquière une nouvelle dimension chez Pablo.
                                    <div class="clear"></div>
                                    <div class="author">Atchoum, Chicoutimi.</div>
                                </li>
                            </ul>                     
                        </div>
                        <div class="span4">
                            <h2 class="title">DERNIERES NOUVELLES</h2>
                            <div class="fb-like-box" data-href="https://www.facebook.com/arriba.ec" data-width="300" data-height="210" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
                        </div>         	
                    </div>
                </div>            
            </div>

            <div class="footer_bottom">

            <div class="row">
                <div class="foot_menu">
                    <div class="span12">
                        <script>
                            (function() {
                                var cx = '009833121842273863740:b9ratqf4tac';
                                var gcse = document.createElement('script');
                                gcse.type = 'text/javascript';
                                gcse.async = true;
                                gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                                        '//www.google.com/cse/cse.js?cx=' + cx;
                                var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(gcse, s);
                            })();
                        </script>
                        <gcse:search></gcse:search>
                    </div>
                </div>
            </div>

            </div>
        </div>
        <!--//footer-->
        
        <?php include("Includes/login/loginpopup.php"); ?>
 
    </body>
</html>