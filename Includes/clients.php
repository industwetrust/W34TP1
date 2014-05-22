<?php 
    if(!isset($_SESSION["login"]))
    {
        echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
    
    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
    $nom =$_SESSION["login"];
    $query = "SELECT * FROM customers WHERE Username =  '". $nom."'";
    $result = $mySqli->query($query);
    if($result->num_rows ==1){
        //L'usager est Trouvé
        $ligne = $result->fetch_assoc();
        $Utilisateur = $ligne["Username"];
        $Phone       = $ligne["Phone"];
        $Email       = $ligne["Email"];
        $FirstName   = $ligne["FirstName"];
        $LastName    = $ligne["LastName"];
        $Created     = $ligne["RegisterDate"];
    
    }

?>

<script type="text/javascript" >
    $(document).ready(function () {
       $("input#txtEdPass").hide(); 
        BarrerDebarrer("true");
        
        $("input#txtEdPassword ").hide(); 
        $("input#txtEdPassword2").hide();    
            
    function BarrerDebarrer(Choix) 
    {
	 
        $("#txtEdFirstname").prop("disabled", Choix);
        $("#txtEdLastname ").prop("disabled", Choix);
        $("#txtEdPhone    ").prop("disabled", Choix);
        $("#txtEdEmail    ").prop("disabled", Choix);
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
            });
</script>  
<div class="container-fluid">
  <div class="span12">
    
    <div class="row">
      <div class="span4">          
        <?php include ("ChargerImage.php");
              if (file_exists("img/profile/".$_SESSION["login"].".jpg"))
              {
                  $dir = "img/profile/".$_SESSION["login"].".jpg";
              }
              else
              {
                  $dir = "";
              }
        ?>
          <img id="profileImage" BorderStyle="Double" width="150" height="150" 
               ImageAlign="Middle" title="Selectionez votre photo" src="<?= $dir ?>"/>
          <br />
          <br />
        <form id="ChargerPhoto" action=# enctype="multipart/form-data" method="POST">
<!--          <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">-->
            <fieldset>
                  <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                    <input name="fichier" type="file" id="fichier_a_uploader" class="btn dark_btn" /><br />
                    <input type="submit" name="profile" value="Changer la photo" class="btn send_btn"/>
                  </p>
              </fieldset>
        </form>

      </div>
      <div class="span4">
          <h2>Information Personnel</h2>
        <form id='frmRegister' method="POST" action="index.php?page=registrer">
            Utilisateur :<label id='EdUsername'       name='Username' ><?= $Utilisateur?></label>
          <input id='txtEdPass      '  name='txtPassword'  type="password" maxlength="40" placeholder="Mot de passe Actuel" />
          <input id='txtEdPassword  '  name='txtPassword'  type="password" maxlength="40" placeholder="Nouvelle mot de passe" />
          <input id='txtEdPassword2 '  name='txtPassword2'  type="password" maxlength="40" placeholder="Répéter mot de Passe" />
          <input id='txtEdFirstname'  value="<?= $FirstName ?>" name='txtFirstname' type="text"     maxlength="40" placeholder="Prénom" onkeypress="return validerTexte(event)"/>
          <input id='txtEdLastname '  value="<?= $LastName ?>" name='txtLastname'  type="text"     maxlength="40" placeholder="Nom" onkeypress="return validerTexte(event)"   />
          <input id='txtEdPhone    '  value="<?= $Phone ?>" name='txtPhone'     type="number"   maxlength="40" placeholder="# Mobile, écrit seulement chiffres" onkeypress="return Valider(event)" />
          <input id='txtEdEmail    '  value="<?= $Email ?>" name='txtemail'     type="email"    maxlength="40" placeholder="Courriel" />
          <label id='EdCreated      '  name='created'     ><?= $Created ?></label>
          <br />

          <div class="action_btns">
              <div class="one_half"><a href="#" class="btn dark_btn"><i class="fa fa-angle-double-left"></i> Retour</a></div>
              <div class="one_half last"><a onclick="SubmitRegisterFormIfValid();" class="btn send_btn">Modifier</a></div>
          </div>
        </form>
      
      </div>
      <div class="span4">
          <h2>Commande d'aujourd'hui</h2>
          <?php include("Includes/ViewCart.php"); ?>
      </div>
    </div>
  </div>
</div>







<!--
                <div>
                    <asp:FileUpload ID="FileUpload1" runat="server"/>
                    <asp:RegularExpressionValidator id="ImageValidator1" Display="Dynamic" runat="server" 
                        ErrorMessage="Seulement archives jpg sont acceptées!" 
                        ValidationExpression="^.*\.(jpg|JPG|jpeg|JPEG|PNG|png)$" 
                        ControlToValidate="FileUpload1" ValidationGroup="Image" CssClass="field-validation-error" />
                    <asp:RequiredFieldValidator id="image1" runat="server" Display="Dynamic"
                        ErrorMessage="Selectioner un image!" ControlToValidate="FileUpload1" 
                        ValidationGroup="Image" CssClass="field-validation-error" />
                </div>
                <div>
                    <br />
                    <asp:LinkButton ID="UploadImage" runat="server" CssClass="btn btn_blue" 
                         Text="Image de Profil"  ValidationGroup="Image" OnClick="UploadImage_Click" />
                    <br />
                    <br />
                </div>
            </div>
            <div class="moitie">
                <div>
                    <div class="titre">Nom d'utilisateur :</div>
                    <div><strong style="font-size: 18px;"><asp:Label ID="lblUtilisateur" runat="server" Text="" /></strong></div>
                </div>
                <div>
                    <div  class="titre">Prenom :</div>
                    <div><asp:TextBox runat="server" ID="txtPrenom" Enabled="false"/></div>
                    <div>
                        <asp:RegularExpressionValidator ID="RegularExpressionValidator1" Display="Dynamic" runat="server" ControlToValidate="txtprenom"
                              ErrorMessage="acepted a-z ou - et _" ValidationExpression="([a-zA-Z_\-]+)"  ValidationGroup="modPersonalInfo"/>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator1" Display="Dynamic" runat="server" ControlToValidate="txtprenom"
                              CssClass="field-validation-error" ErrorMessage="* Le Prenom est requis"  ValidationGroup="modPersonalInfo"/>
                    </div>
                </div>
                <div>
                    <div  class="titre">Nom :</div>
                    <div><asp:TextBox runat="server" ID="txtNom" Enabled="false"/></div>
                    <div>
                        <asp:RegularExpressionValidator ID="RegularExpressionValidator2" Display="Dynamic"  runat="server" ControlToValidate="txtnom"
                              ErrorMessage="acepted a-z ou - et _" ValidationExpression="[a-zA-Z_\-]+"  ValidationGroup="modPersonalInfo"/>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator2" Display="Dynamic" runat="server" ControlToValidate="txtnom"
                              CssClass="field-validation-error" ErrorMessage="* Le Nom est requis"  ValidationGroup="modPersonalInfo"/>
                    </div>
                </div>
                <div>
                    <div  class="titre">Date de Naissance :</div>
                    <div>
                        <asp:TextBox runat="server" ID="txtNais" Enabled="false" />
                    </div>
                </div>
                <div  class="titre">Sexe :</div>
                    <div>
                        <asp:RadioButtonList ID="Sexe" CssClass="lstBT" runat="server" RepeatDirection="Vertical" Enabled="False">
                            <asp:ListItem Value="H" >Homme </asp:ListItem>
                            <asp:ListItem Value="F" >Femme </asp:ListItem>
                            <asp:ListItem Value="O" >Outres</asp:ListItem>
                        </asp:RadioButtonList>
                    </div>
                <div>
                    <div  class="titre">Ville :</div>
                    <div>
                        <asp:TextBox runat="server" ID="txtcity" Enabled="false"/>
                    </div>
                </div>
                <div>
                    <div  class="titre">État/Province</div>
                    <div>
                        <asp:TextBox runat="server" ID="txtProvince" Enabled="false"/>
                    </div>
                </div>
                <div>
                    <div  class="titre">Pays</div>
                    <div>
                        <asp:TextBox runat="server" ID="txtPays" Enabled="false"/>
                    </div>
                </div>
                <div>
                    <div class="titre">Courriel :</div>
                    <div><asp:TextBox runat="server" ID="txtCourriel" Enabled="false"/></div>
                    <div>
                        <asp:RegularExpressionValidator Display="Dynamic" ID="valEmail" runat="server" ErrorMessage="Courriel invalide"
                              CssClass="field-validation-error" ControlToValidate="txtCourriel" 
                              ValidationExpression ="([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})"  ValidationGroup="modPersonalInfo"/>
                        <asp:RequiredFieldValidator Display="Dynamic" ID="valcourriel" runat="server" ControlToValidate="txtCourriel"
                              CssClass="field-validation-error" ErrorMessage="* Le champ Courriel est requis." ForeColor="Red"  ValidationGroup="modPersonalInfo"/>
                    </div>
                </div>
                <div>
                    <div class="titre">Created le :</div>
                    <div><asp:TextBox ID="txtCreated" runat="server" Enabled="false" /></div>
                </div>
                <div>
                    <div class="titre">dernier conection le :</div>    
                    <div><asp:TextBox ID="txtLast" runat="server" Enabled="false" /></div>
                </div>-->




