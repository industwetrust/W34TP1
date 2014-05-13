<?php
    header ('charset=utf-8');
    
    if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

    if (isset($_POST)) {
        $toAdd = array();       // Produits à ajouter,
        $toModify = array();    // ...        modifier,
        $toDelete = array();    // ...        détruire
        
        // Enlève ce qui est à enlever du panier
        foreach(array_keys($_POST) as $key) {
//            if (substr($key, 0, 16) === "chkModifyProduct") {
//                array_push($toModify, explode("chkModifyProduct", $key)[1]);
//            }
//            else if (substr($key, 0, 16) === "chkDeleteProduct") {
//                array_push($toDelete, explode("chkDeleteProduct", $key)[1]);
//            }
//            else if (substr($key, 0, 13) === "chkAddProduct") {
//                array_push($toAdd, explode("chkAddProduct", $key)[1]);
//            }
        }
    }
?>

<div id="manageProductCategoriesContainer" style="width: 800px; margin: 0px auto;">
    <form action="#" method="POST">
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

                foreach ($orders as $order) {
                    $product = $mySqli->query("SELECT p.*, pi.ImageURL " . 
                                              "FROM Products p " .
                                              "INNER JOIN ProductImages pi " .
                                              "ON p.ProductID = pi.ProductID " .
                                              "WHERE p.ProductID = " . $order->ProductID . 
                                              " ORDER BY pi.ImageID DESC " .
                                              "LIMIT 1;")->fetch_assoc();
                    
                    echo "<tr>";
                    echo "<td><img style='width:64px; height:64px;' src='Img/products/" . $product["ImageURL"] . "' /></td>";
                    echo "<td>" . $product["ProductName"] . "</td>";
                    echo "<td>" . $product["Price"] . "</td>";
                    echo "<td><input type='text' name='txtQuantity" . $order->ProductID . "' value='$order->Quantity' /></td>";
                    echo "<td>" . $product["Price"] * $order->Quantity . "</td>";
                    echo "</tr>";
                }
            ?>
        </table><br />
        <input type="submit" value="Confirmer">
    </form>
</div>