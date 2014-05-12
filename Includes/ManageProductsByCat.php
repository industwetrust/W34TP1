<!--Cette page permet de dénifir quelles produits entrent dans quelle catégories-->

<?php
    $PRODUCTS_PER_PAGE = 50;

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

    if (isset($_POST)) {
        $updateQuery = "";
        
         foreach(array_keys($_POST) as $key) {
            if (substr($key, 0, 15) === "chkModProdInCat") {
                array_push($toModify, explode("chkModProdInCat", $key)[1]);
            }
        }
        
        print_r($_POST);

//        for ($i = 0, $lim = count($toModify); $i < $lim; $i++) {
//            $id = $toModify[$i];
//
//            if ($_POST["txtProductName" . $id] == "" || $_POST["txtImageURL" . $id] == "") {
//                echo "<div style='color:red;'>Le produit " . $id . " n'a pas pu être modifié car le nom et/ou l'Url de l'image est manquant.</div>";
//            }
//            else {
//                $query = "UPDATE products SET " . 
//                         "ProductName='" .  $_POST["txtProductName" . $id]  . "', " . 
//                         "Description='" .  $_POST["txtProductDesc" . $id]  . "', " . 
//                         "price='" .        $_POST["txtPrice" . $id]        . "', " . 
//                         "unitsInStock='" . $_POST["txtUnitsInStock" . $id] . "' " . 
//                         "WHERE ProductID = " . $id . ";";
//
//                $mySqli->query($query);
//
//                if ($mySqli->affected_rows == 1) {
//                    $okItemsCount++;
//                }
//            }
//        }
//
//        if ($okItemsCount > 0) {
//            echo "<div style='color: green;'>" . $okItemsCount . " produits sur " . count($toModify) . " modifiées avec succès!</div>";
//        }
    }
    
    $products = $mySqli->query("SELECT ProductID, ProductName FROM Products");
    $categories = $mySqli->query("SELECT CategoryID, CategoryName FROM Categories");
    $productCats = $mySqli->query("SELECT CategoryID, productID FROM ProductsCategories"); // productCats: productCategories
    
    $killPage = false;
    
    if ($products->num_rows == 0) {
        echo "<div style='color: red;'>Impossible d'afficher les produits par catégories car aucun produit n'existe.</div>";
        $killPage = true;
    }
    if ($categories->num_rows == 0) {
        echo "<div style='color: red;'>Impossible d'afficher les produits par catégories car aucune catégorie n'existe.</div>";
        $killPage = true;
    }
    if ($killPage) {
        exit();
    }
    
    $categoryIDs = array();
?>
<div id="manageProductsByCatContainer" style="width: 1200px; margin: 0px auto;">
    <form action="#" method="POST">
        <table border="1">
            <?php
                echo "<tr><td></td>";
                while($row = $categories->fetch_assoc()) {
                    array_push($categoryIDs, $row["CategoryID"]);
                    echo "<td>" . $row["CategoryName"] . "(" . $row["CategoryID"] . ")</td>";
                }
                echo "<td>Modifier</td>";
                echo "</tr>";
                    
                while($row = $products->fetch_assoc()) {
                    $pID = $row["ProductID"];
                    
                    echo "<tr>";
                    echo "<td>" . $pID . "-" . $row["ProductName"] . "</td>";
                    
                    for ($i = 0; $i < count($categoryIDs); $i++) {
                        echo "<td><input type='checkbox' " .
                                        "name='chkProdInCat-" . $pID . "," . $categoryIDs[$i] . "' " . 
                                        "onclick='CheckModifyChkBox(" . $pID . ")' /></td>";
                    }
                    echo "<td><input id='chkModProdInCat" . $pID . "' type='checkbox' name='chkModProdInCat" . $pID . "' value='Modify' /></td>";
                    
                    echo "</tr>";
                }
            ?>
        </table><br />
        <input type="submit" value="Confirmer">
    </form>
</div>

<script type="text/javascript">
    function CheckModifyChkBox(productID) {
        document.getElementById('chkModProdInCat' + productID).checked = true;
    }
</script>