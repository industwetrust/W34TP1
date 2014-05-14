<?php
    header ('charset=utf-8');

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

    if (isset($_POST)) {
        $toAdd = array();       // Produits à ajouter,
        $toModify = array();    // ...        modifier,
        $toDelete = array();    // ...        détruire
        
        // Vérifie ce qui est à modifier, détruire, ajouter
        foreach(array_keys($_POST) as $key) {
            if (substr($key, 0, 16) === "chkModifyProduct") {
                array_push($toModify, explode("chkModifyProduct", $key)[1]);
            }
            else if (substr($key, 0, 16) === "chkDeleteProduct") {
                array_push($toDelete, explode("chkDeleteProduct", $key)[1]);
            }
            else if (substr($key, 0, 13) === "chkAddProduct") {
                array_push($toAdd, explode("chkAddProduct", $key)[1]);
            }
        }
        
        // Updates
        if (count($toModify) > 0) {
            $okItemsCount = 0;
            
            for ($i = 0, $lim = count($toModify); $i < $lim; $i++) {
                $id = $toModify[$i];
                
                if ($_POST["txtProductName" . $id] == "" || $_POST["txtImageURL" . $id] == "") {
                    echo "<div style='color:red;'>Le produit " . $id . " n'a pas pu être modifié car le nom et/ou l'Url de l'image est manquant.</div>";
                }
                else {
                    $query = "UPDATE products SET " . 
                             "ProductName='" .  $_POST["txtProductName" . $id]  . "', " . 
                             "Description='" .  $_POST["txtProductDesc" . $id]  . "', " . 
                             "price='" .        $_POST["txtPrice" . $id]        . "', " . 
                             "unitsInStock='" . $_POST["txtUnitsInStock" . $id] . "', " . 
                             "ImageURL='" .     $_POST["txtImageURL" . $id] . "' " . 
                             "WHERE ProductID = " . $id . ";";
                    
                    $mySqli->query($query);
                    
                    if ($mySqli->affected_rows == 1) {
                        $okItemsCount++;
                    }
                }
            }
            
            if ($okItemsCount > 0) {
                echo "<div style='color: green;'>" . $okItemsCount . " produits sur " . count($toModify) . " modifiées avec succès!</div>";
            }
        }
        
        // Deletes
        if (count($toDelete) > 0) {
            $query = "DELETE FROM products WHERE productID IN (";
            for ($i = 0, $lim = count($toDelete); $i < $lim; $i++) {
                $query .= $toDelete[$i];
                
                if ($i < $lim - 1) {
                    $query .= ", ";
                }
            }
            
            $query .= ");";

            $mySqli->query($query);
            if ($mySqli->affected_rows == count($toDelete)) {
                echo "<div style='color: green;'>" . $mySqli->affected_rows . " produits détruits avec succès!</div>";
            }
            else {
                echo "<div style='color: red;'>" . $mySqli->affected_rows . " produits détruits sur " . count($toDelete) . ". Err msg: " . $mySqli->error . "</div>";
            }
        }
        
        // Inserts
        if (count($toAdd) > 0) {
            $okItemsCount = 0;
            $query = "INSERT INTO Products (productName, Description, price, unitsInStock, ImageURL) VALUES ";
            for ($i = 0, $lim = count($toAdd); $i < $lim; $i++) {
                $id = $toAdd[$i];

                if ($_POST["txtProductName" . $id] == "" || $_POST["txtImageURL" . $id] == "") {
                    echo "<div style='color:red;'>Le produit " . $id . " n'a pas pu être ajouté car le nom et/ou l'Url de l'image est manquant.</div>";
                }
                else {
                    if ($okItemsCount++ > 0) {
                        $query .= ", ";
                    }
                    
                    $query .= "('" . $_POST["txtProductName" . $id] . "', '" .
                                     $_POST["txtProductDesc" . $id] . "', '" .
                                     $_POST["txtPrice"       . $id] . "', '" .
                                     $_POST["txtUnitsInStock" . $id] . "', '" .
                                     $_POST["txtImageURL" . $id] . "')'";
                }
            }
            
            if ($okItemsCount > 0) {
                $query .= ";";
                
                $mySqli->query($query);
                if ($mySqli->affected_rows == $okItemsCount) {
                    echo "<div style='color: green;'>" . $mySqli->affected_rows . " produits ajoutées avec succès!</div>";
                }
                else {
                    echo "<div style='color: red;'>" . $mySqli->affected_rows . " produits ajoutées sur " . $okItemsCount . ". Err msg: " . $mySqli->error . "</div>";
                }
            }
        }
    }
    
    $getProductsQuery = "SELECT ProductID, ProductName, Description, Price, UnitsInStock, ImageURL FROM products";
    
    $products = $mySqli->query($getProductsQuery);
?>

<div id="manageProductCategoriesContainer" style="width: 1400px; margin: 0px auto;">
    <form action="#" method="POST">
        <table border="1">
            <tr>
                <td>ID</td>
                <td>Nom de produit</td>
                <td>Description</td>
                <td>Prix</td>
                <td>Unités en stocks</td>
                <td>Nom image</td>
                <td>Image</td>
                <td>Ajouter</td>
                <td>Modifier</td>
                <td>Détruire</td>
            </tr>
            <?php
                while($row = $products->fetch_assoc()) {
                    $lastProductID = $row["ProductID"];
                    $price = $row["Price"] == '' ? '-' : $row["Price"];
                    $unitsInStock = $row["UnitsInStock"] == '' ? '-' : $row["UnitsInStock"];
                    $onChangeEvent = "onchange=\"document.getElementsByName('chkModifyProduct" . $lastProductID . "')[0].checked = true\"";
                    $deletionDisabled = $mySqli->query("SELECT COUNT(*) FROM ProductsCategories WHERE ProductID = " . $lastProductID)->fetch_row()[0] > 0 ? "disabled" : "";
                    echo "<tr>";
                    echo "<td>" . $lastProductID . "</td>";
                    echo "<td><input type='text' name='txtProductName" . $lastProductID . "' value='" . $row["ProductName"] . "' " . $onChangeEvent . " /></td>";
                    echo "<td><input type='text' name='txtProductDesc" . $lastProductID . "' value='" . $row["Description"] . "' " . $onChangeEvent . " /></td>";
                    echo "<td><input type='text' name='txtPrice" . $lastProductID . "' value='" . $price . "' " . $onChangeEvent . " /></td>";
                    echo "<td><input type='text' name='txtUnitsInStock" . $lastProductID . "' value='" . $unitsInStock . "' " . $onChangeEvent . " /></td>";
                    echo "<td><input type='text' name='txtImageURL" . $lastProductID . "' value='" . $row["ImageURL"] . "' " . $onChangeEvent . " /></td>";
                    echo "<td><img style='width: 64px; height:64px;' src=' " . $PRODUCT_IMGS_PATH . $row["ImageURL"] . "'></td>";
                    echo "<td></td>";
                    echo "<td><input type='checkbox' name='chkModifyProduct" . $lastProductID . "' value='Modify' /></td>";
                    echo "<td><input type='checkbox' name='chkDeleteProduct" . $lastProductID . "' value='Delete' " . $deletionDisabled . " /></td>";
                    echo "</tr>";
                }

                for ($i = $lastProductID+1; $i <= $lastProductID + 5; $i++) {
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td><input type='text' name='txtProductName" . $i . "' value='" . $row["ProductName"] . "' /></td>";
                    echo "<td><input type='text' name='txtProductDesc" . $i . "' value='" . $row["Description"] . "' /></td>";
                    echo "<td><input type='text' name='txtPrice" . $i . "' value='0.00' /></td>";
                    echo "<td><input type='text' name='txtUnitsInStock" . $i . "' value='0' /></td>";
                    echo "<td><input type='text' name='txtImageURL" . $i . "' value='' /></td>";
                    echo "<td></td>";
                    echo "<td><input type='checkbox' name='chkAddProduct" . $i . "' value='Add' /></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            ?>
        </table><br />
        <input type="submit" value="Confirmer">
    </form>
</div>