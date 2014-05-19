<?php

    Facebook\FacebookSession::setDefaultApplication('155567074550166', '90e9e6df005f20b5a193c36d23fd713f');

    $helper = new Facebook\FacebookJavaScriptLoginHelper();
    try {
        $session = $helper->getSession();
                    if ($session) {
            // Logged in.
    $user_profile = (new Facebook\FacebookRequest(
      $session, 'GET', '/me'
    ))->execute()->getGraphObject(Facebook\GraphUser::className());
    
    echo $user_profile->getId();

//    echo "Name: " . $user_profile->getName();


          }

    } catch(\Facebook\FacebookRequestException $ex) {
        echo ("jojojo");
        // When Facebook returns an error
    } catch(\Exception $ex) {
        echo ("buuuuuuuuuuuuu");
        // When validation fails or other local issues
    }

?>

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
<div id="fb-root"></div>

<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '155567074550166',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0

  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/fr_CA/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
        
  }
</script>

<div id="modal" class="popupContainer" style="display:none;">
    <header class="popupHeader">
        <span class="header_title">Connexion</span>
        <span class="modal_close"><i class="fa fa-times"></i></span>
    </header>

    <section class="popupBody">
        <!-- Social Login -->
        <div class="social_login">
            <div class="">
                <a href="#" class="social_box fb">
                    <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"
                            data-scope="email, user_birthday" ></div>

                </a>

                <a href="#" class="social_box google">
                    <span class="icon"><i class="fa fa-google-plus"></i></span>
                    <span class="icon_title">Utiliser Google</span>
                </a>
            </div>

            <div class="centeredText">
                <span>Ou utiliser votre courriel</span>
            </div>

            <div class="action_btns">
                <div class="one_half"><a href="#" id="login_form" class="btn">Se connecter</a></div>
                <div class="one_half last"><a href="#" id="register_form" class="btn">S'inscrire</a></div>
            </div>
        </div>

        <!-- Login form -->
        <div class="user_login">
            <form id='frmLogin' method="POST" action="index.php?page=login">
                <label>Nom d'utilisateur</label>
                <input id='txtRegUsername' name='txtUsername' type="text" />
                <br />

                <label>Mot de passe</label>
                <input id='txtRegPassword' name='txtPassword' type="password" />
                <br />

                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn dark_btn"><i class="fa fa-angle-double-left"></i> Retour</a></div>
                    <div class="one_half last"><a onclick="SubmitLoginFormIfValid();" class="btn send_btn">Se connecter</a></div>
                </div>
            </form>

            <a href="#" class="forgot_password">Mot de passe oublié?</a>
        </div>

        <!-- Register Form -->
        <div class="user_register">
            <form id='frmRegister' method="POST" action="index.php?page=registrer">
                <label>Nom d'utilisateur</label>
                <input id='txtRegUsername' name='txtUsername' type="text" maxlength="60" />
                <br />

                <label>Mot de passe</label>
                <input id='txtRegPassword' name='txtPassword' type="password" maxlength="60" />
                <br />
                
                <label>Prénom</label>
                <input id='txtRegFirstname' name='txtFirstname' type="text" maxlength="60" />
                <br />
                
                <label>Nom</label>
                <input id='txtRegLastname' name='txtLastname' type="text" maxlength="60" />
                <br />

                <label># Mobile</label>
                <input id='txtRegPhone' name='txtPhone' type="email" maxlength="15" />
                <br />

                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn dark_btn"><i class="fa fa-angle-double-left"></i> Retour</a></div>
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
        if (ById('txtRegUsername').value === "" || ById('txtRegPassword').value === "") {
            alert("Assurez-vous que tous les champs sont bien remplis");
        }
        else {
            document.getElementById('frmLogin').submit();
        }
    };
    
    function SubmitRegisterFormIfValid() {
        if (ById('txtRegUsername').value === "" ||
            ById('txtRegPassword').value === "" ||
            ById('txtRegFirstname').value === "" ||
            ById('txtRegLastname').value === "" ||
            ById('txtRegPhone').value === "")
        {
            alert("Assurez-vous que tous les champs sont bien remplis");
        }
        else {
            document.getElementById('frmRegister').submit();
        }
    };
    
    $(".modal_trigger").leanModal({top: GetAppropriateTop(), overlay: 0.6, closeButton: ".modal_close"});

    $(function() {
        // Calling Login Form
        $("#login_form").click(function() {
            $(".social_login").hide();
            $(".user_login").show();
            return false;
        });

        // Calling Register Form
        $("#register_form").click(function() {
            $(".social_login").hide();
            $(".user_register").show();
            $(".header_title").text('Register');
            return false;
        });

        // Going back to Social Forms
        $(".dark_btn").click(function() {
            $(".user_login").hide();
            $(".user_register").hide();
            $(".social_login").show();
            $(".header_title").text('Login');
            return false;
        });

    });
    
    
</script>
