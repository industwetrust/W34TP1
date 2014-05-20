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
                    <p>57 rue Jacques-Bacon<br/>Chicoutimi, (Qc) G7H 3R3</p>
                    <p>Téléphone: +1 (581) 234-0581<br/>Email: <a href="mailto:#">pablo@arriba.ec</a>
                        <br/>
                        Facebook: <a href="#">http://www.facebook.com/arriba.ec</a>
                    </p> 
                    <br/>
                    <div id='map'>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d661.9658405766752!2d-71.04041065968676!3d48.420767475017364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc020bbcee462a3%3A0xa2cfed329a02cbc2!2sColl%C3%A8ge+MultiHexa!5e0!3m2!1sfr!2s!4v1400547804472" 
                        width="400" height="300" frameborder="0" style="border:0">
                    </iframe>
                    </div>
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
                                <div class="span4">

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
                    if (msg === 'OK') {
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
        
        $("#ajax-contact-form").reset(function() {
            $(".span7").text = "";
        });
    });
</script>