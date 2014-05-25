<?php

    if(!isset($_SESSION["login"]))
    {
        echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
    $msgError = "";
    if( empty($_POST['txtShort']) ||
        empty($_POST['txtNomAdre']) ||
        empty($_POST['txtAdresse']) ||
        empty($_POST['txtCityAdre']) ||
        empty($_POST['txtProvince']) ||
        empty($_POST['txtPays']) ||
        empty($_POST['Billing']) ||
        empty($_POST['Shipping']))
    {
        $msgError = "";
    }
    else{
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $query = "SELECT * FROM addresses WHERE ShortName = '".$_POST['txtShort']."' AND"
                . "CustomerID = ".$_SESSION["ID"];
        $result2 = $mySqli->query($query);
        if($result->num_rows  > 0){
            $msgError = "Existé déjà un Addresse avec ce nom court";
        }
        else{
            $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
            $query = "INSERT INTO Addresses (  * FROM addresses WHERE ShortName = '".$_POST['txtShort']."' AND"
                    . "CustomerID = ".$_SESSION["ID"];
            $result2 = $mySqli->query($query);
        }
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

<div class="row">
    <div class="span12">
        <div class="span3"></div>
        <div class="span4">
            <h2>Engeristrer Un Nouvelle Adresse</h2>
            <form id='AddAdresse' method="POST" action="#">
            <br/>
            <div id="msgPass">Selectioner un nom court pour l'addresse </div>
            <input id='txtShort'  name='txtShort'  type="text" maxlength="40" placeholder="Nom Court" /><br />
            <input id='txtNomAdre'  name='txtNomAdre'  type="text" maxlength="40" placeholder="Nom du destinataire" /><br />
            <input id='txtAdresse'  name='txtAdresse'  type="text" maxlength="40" placeholder="Adresse" /><br />
            <input id='txtCityAdre' name='txtCityAdre' type="text"     maxlength="40" placeholder="Ville" onkeypress="return validerTexte(event)"/><br/>
            <input id='txtProvince'  name='txtProvince'  type="text"     maxlength="40" placeholder="Province" onkeypress="return validerTexte(event)"   /><br/>
            <input id='txtPays' name='txtPays'     type="text"   maxlength="40" placeholder="Pays" onkeypress="return Valider(event)" /><br/>
            <input id='Billing'  value="1" name='Billing'     type="checkbox" /> adresse de facturation ?<br/>
            <input id='Shipping'  value="1" name='Shipping'     type="checkbox" /> adresse de envoi ?
            <br/>
            <br/>
            <div class="action_btns">
                <div class="one_half" id='btnAnuler'><a href="#" class="btn dark_btn" onclick="refresh();"> Anuler</a></div>
                <div class="one_half last"><input onclick="Modifier();" class="btn send_btn" id="cmdModifier" value="Ajouter" /></div>
                <div class="one_half last"><input onclick="SubmitRegisterFormIfVal();" class="btn send_btn" id="cmdEnregistrer" value="Enregistrer" /></div>
            </div>
        </form>
        </div>
    </div>
</div>



















<div class="row">
    <div class="span12">
        <div class="span3">

        </div>
        <div class="span7">
          <h2>Adresses enregistrées</h2>
    <?php 
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $query = "SELECT * FROM addresses where CustomerID = ".$_SESSION["ID"];
        $result2 = $mySqli->query($query);
        $lastOrderID = -1;
        $totalOld = 0;
        while($ligne = $result2->fetch_assoc()){
    ?>
          <div>
          <div>Nom Court :</div>
          <div><h2><?= $ligne["ShortName"] ?></h2></div>
          <div></div>
          <address>
              <strong><?= $ligne["nomPersone"] ?></strong>
              <br>
              <?= $ligne["Address"] ?>
              <br>
              <?= $ligne["City"] ?> / <?= $ligne["Province"] ?> / <?= $ligne["Country"] ?>
              <br>
              <br>
              <?= $ligne["CodePostal"] ?>
          </address>
            </div>
          <br />
          <br />
            
     <?php   } ?>
        </div>
    </div>  
</div>



