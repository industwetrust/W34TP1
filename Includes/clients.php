<?php 

    if(!isset($_SESSION["login"]))
    {
        echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
$ups="";
if (empty($_POST["txtEdPass"]) || empty($_POST["txtEdFirstname"]) || empty($_POST["txtEdLastname"]))
{
    $ups = "";
}
else {
    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
        //valider le pasword actuel
    $pass = md5($_POST["txtEdPass"]);
    $nom =$_SESSION["login"];
    $query = "SELECT * FROM customers WHERE Username =  '". $nom. "' AND PASSWORD =  '". $pass."'";
    $result = $mySqli->query($query);
    if($result->num_rows ==1){
        //L'usager est Trouvé
        $ligne = $result->fetch_assoc();
        //valider si l'utilisateur change son mot de passe
        if(!empty($_POST["txtEdPassword"]) && !empty($_POST["txtEdPassword2"]))
        {
            if ($_POST["txtEdPassword"] == $_POST["txtEdPassword2"]){
                //valider si l'utilisateur change de mot de passe
                $pass = $_POST["txtEdPassword"];
            }
        }
        //faire la modification 
        $mySqli->query("UPDATE Customers SET Password = '".$pass."', Firstname = '". $_POST["txtEdFirstname"].
                        "', Lastname = '".$_POST["txtEdLastname"]."', Phone = '".$_POST["txtEdPhone"].
                        "', Email = '".$_POST["txtEdemail"]."' WHERE Username = '".$nom."'");
        if ($mySqli->affected_rows == 1) {
            $ups = '<div class="notification_ok">Votre Information a été modifiée</div>';
        }
        else 
        {
            $ups = "<div class='notification_error'>Desolé la modification n'est pas disponible maintenant, essayer plus tard</div>";
        }
                    
    }
 else {
        $ups = "<div class='notification_error'>Mot de passe incorrect</div>";
    }
}
    
$mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
$nom =$_SESSION["login"];
$query = "SELECT * FROM customers WHERE Username =  '". $nom."'";
$result = $mySqli->query($query);
if($result->num_rows ==1){
    //L'usager est Trouvé
    $ligne = $result->fetch_assoc();
    $Utilisateur = " ".$ligne["Username"];
    $Phone       = $ligne["Phone"];
    $Email       = $ligne["Email"];
    $FirstName   = $ligne["FirstName"];
    $LastName    = $ligne["LastName"];
    $Created     = $ligne["RegisterDate"];
  
}
?>

<script type="text/javascript" >
    $(document).ready(function () {
        Barrer(true);
        $("#txtEdPass").hide(); 
        $("#txtEdPassword").hide(); 
        $("#txtEdPassword2").hide();
        $("#btnAnuler").hide();
        $("#cmdEnregistrer").hide();
        $("#msgPass").hide();
    });

    function Modifier(){
        $("#txtEdPass").show();
        $( "#txtEdPass" ).focus();
        $("#msgPass").show();
        $("#txtEdPassword").show(); 
        $("#txtEdPassword2").show();
        $("#btnAnuler").show();
        $("#cmdEnregistrer").show();
        Barrer(false);
        $("#cmdModifier").hide();
        return;
    }

    msg = "";
    function SubmitRegisterFormIfVal() {
        if (!validerEcran2()){
            alert(msg);
            return;
        }
        if (ById('txtEdPass').value === "" ||
            ById('txtEdFirstname').value === "" ||
            ById('txtEdLastname').value === "" )
            {
               msg = "Assurez-vous que tous les champs sont bien remplis";
                alert(msg);
            }
            else {
               ById('frmModifier').submit();
            }
        }

    function validerEcran2(){
        
        if (ById('txtEdPassword').value != ById('txtEdPassword2').value){
            msg = "Mots de passe distincts";
            return false;
        }
        var temp = ById("txtEdEmail").value;
        var email = new RegExp("([a-zA-Z0-9_\\-\\.]+)@([a-zA-Z0-9_\\-\\.]+)\\.([a-zA-Z]{2,5})");
        var OK = email.test(temp);
        if(!OK)
        {
            msg = "Le courriel n'est pas Valide";
            return false;
        }
      return true;  
    };
    
    function Barrer(Choix) 
    {
        $("#txtEdFirstname").prop("disabled", Choix);
        $("#txtEdLastname ").prop("disabled", Choix);
        $("#txtEdPhone    ").prop("disabled", Choix);
        $("#txtEdEmail    ").prop("disabled", Choix);
    };
        
    function refresh(){
        window.location.reload();
    }

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

            <fieldset>
                  <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                    <input name="fichier" type="file" id="fichier_a_uploader" /><br />
                    <input type="submit" name="profile" value="Changer la photo" class="btn send_btn"/>
                    <br/> Seulment sont acceptées images JPG de mois de 1 megabyte
                  </p>
              </fieldset>
        </form>

      </div>
      <div class="span4">
          <h2>Information Personnel</h2>
          <?= $ups?>
        <form id='frmModifier' method="POST" action="#">
            Utilisateur :<?= $Utilisateur?><br/>
            <input id='txtEdPass'  name='txtEdPass'  type="password" maxlength="40" placeholder="Mot de passe Actuel" />
            <div id="msgPass">Pour garder votre mot de passe actuel, laisser vide les champs Nouvelle mot de passe et Répéter </div>
            <input id='txtEdPassword'  name='txtEdPassword'  type="password" maxlength="40" placeholder="Nouvelle mot de passe" />
            <input id='txtEdPassword2'  name='txtEdPassword2'  type="password" maxlength="40" placeholder="Répéter mot de Passe" /><br />
            Prenom :&nbsp;<input id='txtEdFirstname'  value="<?= $FirstName ?>" name='txtEdFirstname' type="text"     maxlength="40" placeholder="Prénom" onkeypress="return validerTexte(event)"/>
            <br/>Nom : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id='txtEdLastname'  value="<?= $LastName ?>" name='txtEdLastname'  type="text"     maxlength="40" placeholder="Nom" onkeypress="return validerTexte(event)"   />
            <br/>Phone :&nbsp;&nbsp;&nbsp;<input id='txtEdPhone'  value="<?= $Phone ?>" name='txtEdPhone'     type="number"   maxlength="40" placeholder="# Mobile, écrit seulement chiffres" onkeypress="return Valider(event)" />
            <br/>Courriel:&nbsp;<input id='txtEdEmail'  value="<?= $Email ?>" name='txtEdemail'     type="email"    maxlength="40" placeholder="Courriel" />
            <br/>Inscrit le: &nbsp;<label id='EdCreated'  name='created'     ><?= $Created ?></label>
            <br />

            <div class="action_btns">
                <div class="one_half" id='btnAnuler'><a href="#" class="btn dark_btn" onclick="refresh();"> Anuler</a></div>
                <div class="one_half last"><input onclick="Modifier();" class="btn send_btn" id="cmdModifier" value="Modifier" /></div>
                <div class="one_half last"><input onclick="SubmitRegisterFormIfVal();" class="btn send_btn" id="cmdEnregistrer" value="Enregistrer" /></div>
            </div>
        </form>
      
      </div>
        <div class="span4">
            <div style="border:3px solid red; padding:10px;">
                <h2>Commande d'aujourd'hui</h2>
                <?php include("Includes/ViewCart.php"); ?>
            </div>
      </div>
    </div>
    <div class="row">
      <div class="span5"> 
          <h2>Anciennes Commandes</h2>
          <?php 
          $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
          $nom =$_SESSION["login"];
          $query = "SELECT o.OrderID, o.OrderDate, p.ProductName, p.Price , od.Quantity, o.BillingAddress, o.ShippingAddress, c.Username 
                    FROM orders o INNER JOIN orderdetail od on o.OrderID = od.OrderId INNER JOIN products p on od.ProductID = p.ProductID 
                    INNER JOIN customers c on o.CustomerID = c.CustomerID WHERE c.Username = '".$nom."'";
          $result2 = $mysqli->query($query);
          $lastOrderID = -1;
        while($ligne = $result2->fetch_assoc()){
            
            if($ligne["OrderID"] > $lastOrderID);
        $code = $ligne["productCode"];
        ?>
          <table border='1'>
        <tr>
            <th>No Facture</th>
            <th>Date</th>
            <th>Produit</th>
            <th>quantityInStock</th>
            <th>buyPrice</th>
            <th>Qty</th>
            <th style="background-image:url('Images/Cart.png');width:128px; height:128px;
                       color:#A00;font-size:48px;">
                <?=$itemCount;?>
            </th>
        </tr>

        <tr>
            <td><?=$code?></td>
            <td><?=$ligne["productName"]?></td>
            <td><?=$ligne["productScale"]?></td>
            <td><?=$ligne["quantityInStock"]?></td>
            <td><?=$ligne["buyPrice"]?></td>
            <td><input type="text" size="1" value="<?=$_SESSION["cart"][$code]?>" /></td>
            <td><input type="submit" name="<?=$ligne["productCode"] . "_Button"?>" value="Supprimer" /></td>
        </tr>
        <?php
    }
    ?>
        
    </table>
          
      </div>
    </div>
  </div>
</div>








