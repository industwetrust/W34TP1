<?php
    
    if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
?>

<div id="manageProductCategoriesContainer" style="width: 800px; margin: 0px auto;">
    <form action="index.php?page=AjouterCommande" method="POST">
        <table border="1">
            <tr>
                <td>Image</td>
                <td>Nom de produit</td>
                <td>Prix Unitaire</td>
                <td>Quantités</td>
                <td>Prix Total</td>
            </tr>
            <?php
                $orders = $_SESSION["Basket"]->GetProductOrders();

                $totalPrice = 0;
                
                foreach ($orders as $order) {
                    $product = $mySqli->query("SELECT * FROM Products WHERE ProductID = " . $order->ProductID)->fetch_assoc();
                    $onChangeEvent = "onchange=\"document.getElementById('tdTotalPrice$order->ProductID').innerHTML = (document.getElementsByName('txtQuantity$order->ProductID')[0].value * " . $product["Price"] . ").toFixed(2); RefreshGrandTotal(); \"";
                    
                    echo "<tr class='productOrderRow'>";
                    echo "<td><img style='width:64px; height:64px;' src='Img/products/" . $product["ImageURL"] . "' /></td>";
                    echo "<td>" . $product["ProductName"] . "</td>";
                    echo "<td class='productPrice'>" . $product["Price"] . "</td>";
                    echo "<td><input class='productQuantity' style='width: 39px; text-align:right;' type='text' name='txtQuantity$order->ProductID' onkeypress='return IsNumberOrControl(event)' maxLength='2' $onChangeEvent value='$order->Quantity' /></td>";
                    echo "<td id='tdTotalPrice$order->ProductID'>" . $product["Price"] * $order->Quantity . "</td>";
                    echo "</tr>";
                    
                    $totalPrice += $product["Price"] * $order->Quantity;
                }
                
                echo "<tr><td>Total:</td><td></td><td></td><td></td><td id='tdGrandTotalPrice'>$totalPrice</td></tr>";
            ?>
        </table><br />
        <input type="submit" value="Confirmer"> <br />
        * Les changements apporté aux quantitées sur cette page ne seront effectif que l'orsque vous appuierez sur "Confirmer".
        <!--<input type="button" value="Rafraîchir" onclick="RefreshGrandTotal()"> <br /> * Lorsque vous cliquez sur "Rafraîchir", les changements apporté à vos quantités de produits ne sont pas enrégistré.
                                                                                        Ils ne seront enrégistré que lorsque vous appuirez sur "Confirmer". -->
        
    </form>
</div>

<script type="text/javascript">
    function ByClass(className) {return document.getElementsByClassName(className);}

    function RefreshGrandTotal() {
        var newGrandTotal = 0;
        
        var productCount = ByClass('productPrice').length;
        
        for (var i = 0; i < productCount; i++) {
            newGrandTotal += parseFloat(ByClass('productPrice')[i].innerHTML) *
                             parseInt(ByClass('productQuantity')[i].value);
        }
        
        document.getElementById('tdGrandTotalPrice').innerHTML = newGrandTotal.toFixed(2);
    }
    
    function IsNumberOrControl(e) {
        var key = window.event ? e.keyCode : e.which;

        return e.keyCode === 8 || e.keyCode === 46 || e.keyCode === 37 || e.keyCode === 39 || e.keyCode >= 48 && key <= 57;
    }
</script>