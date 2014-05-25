<link href="Includes/login/LoginPopup.css" rel="stylesheet">
<script>
    (function($) {
        $.fn.extend({
            leanModal: function(options) {
                var defaults = {
                    top: 100,
                    overlay: 0.5,
                    closeButton: null
                };
                var overlay = $("<div id='lean_overlay'></div>");
                $("body").append(overlay);
                options = $.extend(defaults, options);
                return this.each(function() {
                    var o = options;
                    var modal_id = $(this).attr("href");

                    function showModal() {
                        $("#lean_overlay").click(function() {
                            close_modal(modal_id);
                        });
                        $(o.closeButton).click(function() {
                            close_modal(modal_id);
                        });

                        var modal_height = $(modal_id).outerHeight();
                        var modal_width = $(modal_id).outerWidth();

                        $("#lean_overlay").css({
                            "display": "block",
                            opacity: 0
                        });

                        $("#lean_overlay").fadeTo(200, o.overlay);

                        $(modal_id).css({
                            "display": "block",
                            "position": "fixed",
                            "opacity": 0,
                            "z-index": 11000,
                            "left": 50 + "%",
                            "margin-left": -(modal_width / 2) + "px",
                            "top": o.top + "px"
                        });

                        $(modal_id).fadeTo(200, 1);
                    };

                    $(this).click(function(e) {
                        showModal();
                        e.preventDefault();
                    });
                });

                function close_modal(modal_id) {
                    $("#lean_overlay").fadeOut(200);
                    $(modal_id).css({
                        "display": "none"
                    });
                }
            }
        });
    })(jQuery);
</script>

<div id="modal" class="popupContainer" style="display:none;">
    <header class="popupHeader">
        <span class="header_title">Connexion</span>
        <span class="modal_close"><i class="fa fa-times"></i></span>
    </header>

    <section class="popupBody">
        <!-- Login form -->
        <div class="social_login">
            <form id='frmLogin' method="POST" action="index.php?page=login">
                <input id='txtUsername' name='txtUsername' type="text" maxlength="40" placeholder="Nom d'utilisateur"/>
                <br />

                 <input id='txtPassword' name='txtPassword' type="password" maxlength="40" placeholder="Mot de passe" />
                <br />

                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn" ID="register_form"><i class="fa fa-angle-double-left"></i> Enregistrer</a></div>
                    <div class="one_half last"><a onclick="SubmitLoginFormIfValid();" class="btn send_btn">Se connecter</a></div>
                </div>
            </form>
        </div>


        <!-- Register Form -->
        <div class="user_register">
            <form id='frmRegister' method="POST" action="index.php?page=registrer">
                <input id='txtRegUsername'   name='txtUsername'  type="text"     maxlength="40" placeholder="Nom d'utilisateur" />
                <input id='txtRegPassword'   name='txtPassword'  type="password" maxlength="40" placeholder="Mot de passe" />
                <input id='txtRegPassword2'  name='txtPassword'  type="password" maxlength="40" placeholder="Répéter Mot de Passe" />
                <input id='txtRegFirstname'  name='txtFirstname' type="text"     maxlength="40" placeholder="Prénom" onkeypress="return validerTexte(event)"/>
                <input id='txtRegLastname'   name='txtLastname'  type="text"     maxlength="40" placeholder="Nom" onkeypress="return validerTexte(event)"   />
                <input id='txtRegPhone'      name='txtPhone'     type="number"   maxlength="40" placeholder="# Mobile, écrit seulement chiffres" onkeypress="return Valider(event)" />
                <input id='txtRegemail'      name='txtemail'     type="email"    maxlength="40" placeholder="Courriel" />
                <br />

                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn dark_btn" ><i class="fa fa-angle-double-left"></i> Retour</a></div>
                    <div class="one_half last"><a onclick="SubmitRegisterFormIfValid();" class="btn send_btn">S'inscrire</a></div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    function ById(id) { return document.getElementById(id); };
    
    function GetAppropriateTop() {
        var maxTop = $(window).height() - 601;
        return maxTop < 200 ? maxTop : 200;
    };
    
    function SubmitLoginFormIfValid() {
        if (ById('txtUsername').value === "" || ById('txtPassword').value === "") {
            alert("Assurez-vous que tous les champs sont bien remplis");
        }
        else {
            document.getElementById('frmLogin').submit();
        }
    };
    
    function Valider(e) {
            var key = window.ev ? e.keyCode : e.which; //verifier le navigateur
            // if inmediat  condition ? action si vrai : action si faux
            // key contient le numero ascii de la touche pressee
            // on accepte seulement les chiffres
            if (!((key >= 48 && key <= 57)|| key == 8)) {
                return false;
            }
        };
    
    function validerTexte(e) {
        var key = window.ev ? e.keyCode : e.which;
        if (!((key >= 65 && key <= 90)||(key >= 97 && key <= 122)|| key == 32 || key == 8)) {
                return false;
            }
       
    };
    
    msg = "";
    function SubmitRegisterFormIfValid() {
        if (!validerEcran()){
            alert(msg);
            return;
        }
        
        if (ById('txtRegUsername').value === "" ||
            ById('txtRegPassword').value === "" ||
            ById('txtRegPassword2').value === "" ||
            ById('txtRegFirstname').value === "" ||
            ById('txtRegLastname').value === "" ||
            ById('txtRegemail').value === "" ||
            ById('txtRegPhone').value === "" )

        {
           msg = "Assurez-vous que tous les champs sont bien remplis";
            alert(msg);
        }
        else {
           document.getElementById('frmRegister').submit();
        }
    }
    
    function validerEcran(){
        if (ById('txtRegPassword').value !== ById('txtRegPassword2').value){
            msg = "Mots de passe distincts";
            return false;
        }
        var temp = ById("txtRegemail").value;
        var email = new RegExp("([a-zA-Z0-9_\\-\\.]+)@([a-zA-Z0-9_\\-\\.]+)\\.([a-zA-Z]{2,5})");
        var OK = email.test(temp);
        if(!OK)
        {
            msg = "Le courriel n'est pas Valide";
            return false;
        }
      return true;  
    };
    
    $(".modal_trigger").leanModal({top: GetAppropriateTop(), overlay: 0.2, closeButton: ".modal_close"});

    $(function() {
        
        // Calling Register Form
        $("#register_form").click(function() {
            $(".social_login").hide();
            $(".user_register").show();
            $(".header_title").text('Register');
            return false;
        });

        // Going back to Login Forms
        $(".dark_btn").click(function() {
            $(".user_login").hide();
            $(".user_register").hide();
            $(".social_login").show();
            $(".header_title").text('Login');
            return false;
        });

    });
    
    
</script>
