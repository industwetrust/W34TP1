<?php
    $msgError = "";
    if(!isset($_SESSION["login"]))
    {
        echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
    if( empty($_POST['txtShort']) ||
        empty($_POST['txtNomAdre']) ||
        empty($_POST['txtAdresse']) ||
        empty($_POST['txtCityAdre']) ||
        empty($_POST['txtProvince']) ||
        empty($_POST['txtPays']))
    {
        $msgError = "";
    }
    else{
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $customerID = "select * FROM Customers WHERE UserName = '".$_SESSION["login"]."'";
        $result1 = $mySqli->query($customerID);
        $ligne1="";
        if($result1->num_rows ==1){
                //L'usager est Trouvé
                $ligne1 = $result1->fetch_assoc();
        }
        $query = "SELECT * FROM addresses WHERE ShortName = '".$_POST['txtShort']."' AND"
                . "CustomerID = ".$ligne1["CustomerID"];
        $result = $mySqli->query($query);
        if($result){
            $msgError = '<div class="notification_error">Existé déjà un Addresse avec ce nom court</div>';
        }
        else{
            $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
            $query = "INSERT INTO Addresses (CustomerID, Country, Province, City, Address, ShortName, "
                    . " nomPersone, CodePostal)"."  VALUES(".$ligne1["CustomerID"].", '".$_POST['txtPays']."', '".
                    $_POST['txtProvince']."', '".$_POST['txtCityAdre']."', '".$_POST['txtAdresse']."', '".
                    $_POST['txtShort']."', '".$_POST['txtNomAdre']."', '".$_POST['txtPostal']."')";
            $result = $mySqli->query($query);
            if ($result) {
                    $msgError = '<div class="notification_ok">Addresse ajouté!</div>';
                }
                else {
                    $msgError = "<div class='notification_error'>Un problemme durant l'enregistrement esayer plus tard</div>";
                }
        }
    }
?>

<script type="text/javascript" >
    msg = "";
    function Submitadd() {
        if (ById('txtShort').value === "" ||
            ById('txtNomAdre').value === "" ||
            ById('txtAdresse').value === "" )
            {
               msg = "Assurez-vous que tous les champs sont bien remplis";
                alert(msg);
            }
            else {
               ById('AddAdresse').submit();
            }
        }
    
    function refresh(){
        window.location.reload();
    }

</script> 

<div class="row">
    <div class="span12">
        <div class="span3"></div>
        <div class="span4">
            <?= $msgError ?>
            <h2>Engeristrer Un Nouvelle Adresse</h2>
            <form id='AddAdresse' method="POST" action="#">
            <br/>
            <div id="msgPass">Selectioner un nom court pour l'addresse </div>
            <input id='txtShort'  name='txtShort'  type="text" maxlength="40" placeholder="Nom Court" /><br />
            <input id='txtNomAdre'  name='txtNomAdre'  type="text" maxlength="40" placeholder="Nom du destinataire" /><br />
            <input id='txtAdresse'  name='txtAdresse'  type="text" maxlength="40" placeholder="Adresse" /><br />
            <input id='txtCityAdre' name='txtCityAdre' type="text"     maxlength="40" placeholder="Ville" onkeypress="return validerTexte(event)"/><br/>
            <input id='txtProvince'  name='txtProvince'  type="text"     maxlength="40" placeholder="Province" onkeypress="return validerTexte(event)"   /><br/>
            <input id='txtPays' name='txtPays'     type="text"   maxlength="40" placeholder="Pays" onkeypress="return ValiderTexte(event)" /><br/>
            <input id='txtPostal'  name='txtPostal'  type="text"     maxlength="40" placeholder="CodePostal" /><br/>
            <br/>
            <br/>
            <div class="action_btns">
                <div class="one_half" id='btnAnuler'><a href="#" class="btn dark_btn" onclick="refresh();"> Anuler</a></div>
                <div class="one_half last"><input onclick="Submitadd();" class="btn send_btn" id="cmdEnregistrer" value="Enregistrer" /></div>
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
        $query = "SELECT * FROM addresses where CustomerID = (select CustomerID FROM Customers "
                . "WHERE UserName = '".$_SESSION["login"]."')";
        $result = $mySqli->query($query);
         if($result){
            while($ligne = $result->fetch_assoc()){
    ?>
          <div>
            <div>Nom Court :<strong><?= $ligne["ShortName"] ?></strong></div>
            <div></div>
            <address>
                <strong><?= $ligne["nomPersone"] ?></strong>
                <br>
                <?= $ligne["Address"] ?>
                <br>
                <?= $ligne["City"] ?> / <?= $ligne["Province"] ?> / <?= $ligne["Country"] ?>
                <br>
                <?= $ligne["CodePostal"] ?>
            </address>
              </div>
            <br />
            <br />

       <?php   } 
         }?>
          </div>
      </div>  
  </div>