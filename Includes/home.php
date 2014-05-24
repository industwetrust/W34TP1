        <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" id="camera-css"  href="css/camera.css" type="text/css" media="all">
                <script type="text/javascript" src="js/camera.js"></script>
                <script src="http://jquery.bassistance.de/validate/additional-methods.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //Slider
                $('#camera_wrap_1').camera();

                //Featured works & latest posts
                $('#mycarousel, #mycarousel2, #newscarousel').jcarousel();
            });
        </script>


<!--slider-->
<div id="main_slider">
    <div class="camera_wrap" id="camera_wrap_1">
        <div data-src="img/slider/1.jpg"></div>
        <div data-src="img/slider/2.jpg"></div>
        <div data-src="img/slider/3.jpg"></div> 
        <div data-src="img/slider/4.jpg"></div> 
        
    </div><!-- #camera_wrap_1 -->
    <div class="clear"></div>	
</div>        
<!--//slider-->

<!--planning-->
<div class="wrap planning">
    <div class="container">
        <div class="row">
            <div class="span3">
                <a href="index.php?page=Produits">
                    <span class="img_icon icon1"></span>
                    <span class="link_title">Produits</span>
                </a>
            </div>
            <div class="span3">
                <a href="http://www.facebook.com/arriba.ec">
                    <span class="img_icon icon2"></span>
                    <span class="link_title">Suivez-Nous</span>
                </a>
            </div>
            <div class="span3">
                <a href="index.php?page=Produits&Category=6">
                    <span class="img_icon icon3"></span>
                    <span class="link_title">Promotions</span>
                </a>
            </div>
            <div class="span3">
                <a href="index.php?page=contacts">
                    <span class="img_icon icon4"></span>
                    <span class="link_title">Contactez-Nous</span>
                </a>
            </div>                           	
        </div>
    </div>
</div>
<!--//planning-->

<!--Welcome-->
<div class="wrap block">
    <div class="container welcome_block">
        <div class="welcome_line welcome_t"></div>
        De la fève au gâteau, viens découvrir le processus
        <span>Chocolats fins faits artisanalement à Chicoutimi !</span>
        <div class="welcome_line welcome_b"></div>
    </div>
</div>
<!--//Welcome-->         

<!--featured works-->
<div class="wrap block carousel_block">
    <div class="container">
        <h2 class="upper">Galerie</h2>
        <div class="row">
            <div class="span12">
                <ul id="mycarousel" class="jcarousel-skin-tango">
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/1.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/1.jpg" alt="" />
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li>
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/2.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/2.jpg" alt="" />
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li>
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/3.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/3.jpg" alt="" />
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li> 
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/4.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/4.jpg" alt="" />
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li>
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/5.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/5.jpg" alt="" />à
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li>
                    <li>
                        <div class="hover_img">
                            <a href="img/featured_works/6.jpg" rel="prettyPhoto[portfolio1]">
                            <img src="img/featured_works/6.jpg" alt="" />
                            <span class="portfolio_zoom1"></span></a>                                    
                        </div>
                    </li>                                                       
                </ul>                         
            </div>                
        </div>                
    <!--</div>-->
</div>        
<!--//featured works-->


