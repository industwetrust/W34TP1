<?php
session_start();
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

        <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" id="camera-css"  href="css/camera.css" type="text/css" media="all">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/theme.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/skins/tango/skin.css" />
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="LoginPopup/LoginPopup.js"></script>
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->    
    </head>

    <body>
        <!--header-->
        <div class="header">
            <div class="wrap">
                <div class="navbar navbar_ clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="span4">
                                <div class="logo"><a href="index.php"><img src="img/logopablo.jpg" alt="" /></a></div>                        
                            </div>
                            <div class="span8">
                                <div class="follow_us">
                                    <ul>
                                        <li>Se connecter avec: </li>
                                        <li><a href="http://www.facebook.com/arriba.ec" class="facebook">Facebook</a></li>
<!--                                        <li><a href="http://www.facebook.com/arriba.ec" class="google">Google</a></li>-->
                                        <li><a href="#" class="delicious">Delicious</a></li>
<!--                                        <li><a href="index.php?page=login" class="delicious">Delicious</a></li>-->
                                    </ul>
                                </div>
                                <nav id="main_menu">
                                    <div class="menu_wrap">
                                        <ul class="nav sf-menu">
                                            <li class="current"><a href="index.php">Accueil</a></li>
                                            <li><a href="index.php?page=about">À propos</a></li>
                                            <li class="sub-menu"><a href="javascript:{}">Clients</a>
                                                <ul>
                                                    <li><a class="modal_trigger" href="#modal"><span>-</span>S'inscrire</a></li>
                                                    <li><a class="modal_trigger" href="#modal"><span>-</span>Se connecter</a></li>
                                                    <li><a href="index.php?page=sortir"><span>-</span>Se déconnecter</a></li>
                                                </ul>                                          
                                            </li>
                                            <li class="sub-menu"><a href="javascript:{}">Produits</a>
                                                <ul>
                                                    <li><a href="index.php?page=Produits"><span>-</span>Catalogue</a></li>
                                                    <li><a href="portfolio_3columns.html"><span>-</span>Categories</a></li>
<!--                                                    <li><a href="portfolio_4columns.html"><span>-</span>4 Columns</a></li>                                      -->
                                                </ul>
                                            </li>                                  
                                            <li class="sub-menu"><a href="javascript:{}">Administrer</a>
                                                <ul>
                                                    <li><a href="blog.html"><span>-</span>Utilisateur</a></li>
                                                    <li><a href="blog_post.html"><span>-</span>Produits</a></li> 
                                                    <li><a href="blog_post.html"><span>-</span>Commandes</a></li> 
                                                </ul>
                                            </li>
                                            <li><a href="index.php?page=contacts">Contacter</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div class="follow_us"> PANIER </div>
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
                    case "login" : include("Includes/login.php");
                        break;
                    case "users" : include("Includes/users.php");
                        break;
                    case "registrer" : include("Includes/registrer.php");
                        break;
                    case "sortir" : include("Includes/sortir.php");
                        break;
                    case "about" : include("Includes/about.php");
                        break;
                    case "contacts" : include("Includes/contacts.php");
                        break;
                    case "Produits" : include("Includes/Products.php");
                        break;
                    default : include("Includes/homepage.php");
                        break;
                }
            } else //dans le cast ou l'url ne contient pas de param 'page'
                include("Includes/home.php");
            ?>
        </div>
        <!--//page_container-->

        <!--footer-->
        <div id="footer">
            <div class="wrap">
                <div class="container">
                    <div class="row">
                        <div class="span3">
                            <h2 class="title">Récents tweets</h2>
                            <div class="tweet_block"></div>                       
                        </div>

                        <div class="span3">
                            <h2 class="title">Question?</h2>
                            <form action="Question" method="post">
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
                        <div class="span3">
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
                        <div class="span3">
                            <h2 class="title">DERNIERES NOUVELLES</h2>
                            <iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/arriba.ec&width&height=395&colorscheme=light&show_faces=false&header=false&stream=true&show_border=true&appId=155567074550166" 
                                    scrolling="yes" 
                                    frameborder="0" 
                                    style="border:none; 
                                    overflow:visible ; height:240px;" allowTransparency="true"></iframe>
                        </div>         	
                    </div>
                </div>            
            </div>

            <div class="footer_bottom">

                <div class="wrap">
                    <div class="container">
                        <div class="foot_menu">
                            <div>
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
                                <gcse:search>hola hola</gcse:search>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--//footer-->
        
        <?php include("LoginPopup/LoginPopup.html"); ?>

        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>
        <script type="text/javascript" src="js/camera.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/superfish.js"></script>
        <script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.js"></script>
        <script type="text/javascript" src="js/jquery.tweet.js"></script>
        <script type="text/javascript" src="js/myscript.js"></script>
        <script type="text/javascript">
                                    $(document).ready(function() {
                                        //Slider
                                        $('#camera_wrap_1').camera();

                                        //Featured works & latest posts
                                        $('#mycarousel, #mycarousel2, #newscarousel').jcarousel();
                                    });
        </script>

        
    </body>
</html>