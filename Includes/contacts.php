<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="breadcrumb">
    <div class="wrap">
        <div class="container">
            <a href="index.php">Accueil</a><span>/</span>Contacter
        </div>
    </div>
</div>
<div class="wrap">
    <div class="container">
        <section>
            <div class="row">
                <div class="span4">
                    <h2 class="title"><span>Coordonnées</span></h2>
                    <!--<div id="map"><iframe width="100%" height="310" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=london&sll=37.0625,-95.677068&sspn=42.631141,90.263672&ie=UTF8&hq=&hnear=London,+United+Kingdom&ll=51.500141,-0.126257&spn=0.026448,0.039396&z=14&output=embed"></iframe></div>-->
                    <p>57 rue Jacques-Bacon<br/>Chicoutimi, (Qc) G7H 3R3</p>
                    <p>Téléphone: +1 (581) 234-0581<br/>Email: <a href="mailto:#">pablo@arriba.ec</a><br/>Facebook: <a href="#">http://www.facebook.com/arriba.ec</a></p>                           
                </div>
                <div class="span8">
                    <h2 class="title"><span>Contactez-nous</span></h2>
                    <div class="contact_form">  
                        <div id="note"></div>
                        <div id="fields">
                            <form id="ajax-contact-form" action="">
                                <input class="span7" type="text" name="name" value="" placeholder="Nom (requis)" />
                                <input class="span7" type="text" name="email" value="" placeholder="Email (requis)" />
                                <input class="span7" type="text" name="subject" value="" placeholder="Sujet" />
                                <textarea name="message" id="message" class="span8" placeholder="Message"></textarea>
                                <div class="clear"></div>
                                <input type="reset" class="btn dark_btn" value="Effacer" />
                                <input type="submit" class="btn send_btn" value="Envoyer" />
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>                   
                </div>                	
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#ajax-contact-form").submit(function() {
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "contact_form/contact_process.php",
                data: str,
                success: function(msg) {
                    // Message Sent - Show the 'Thank You' message and hide the form
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#note').html(result);
                }
            });
            return false;
        });
    });
</script>