<!--Cette page permet de dénifir quelles produits entrent dans quelle catégories-->

<?php
    if(!isset($_SESSION["nom"])){
               echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }
    $PRODUCTS_PER_PAGE = 50;

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

    if (!empty($_POST["changedChkBoxes"])) {
        $affectedRows = 0;
        $query = "";
        $toModify = explode(";", $_POST["changedChkBoxes"]);

        foreach($toModify as $modif) {
            $modInfos = explode("_", $modif);
        
            $query = $modInfos[2] == "Add" ? "INSERT INTO ProductsCategories (ProductID, CategoryID) VALUES (" . $modInfos[0] . ", " . $modInfos[1] . ");" : 
                                             "DELETE FROM ProductsCategories WHERE ProductID = " . $modInfos[0] . " AND CategoryID = " . $modInfos[1] . ";";

            $mySqli->query($query);

            if ($mySqli->affected_rows == 1)
                $affectedRows++;
            else
                echo "<div style='color: red;'>" . $mySqli->error . "</div>";
        }
        
        if ($affectedRows == count($toModify)) {
            echo "<div style='color: green;'>" . $affectedRows . " lignes affectées sur " . count($toModify) . "</div>";
        }
        else {
            echo "<div style='color: red;'>" . $affectedRows . " lignes affectées sur " . count($toModify) . ".</div>";
        }
    }
    
    $products = $mySqli->query("SELECT ProductID, ProductName FROM Products");
    $categories = $mySqli->query("SELECT CategoryID, CategoryName FROM Categories");
    $productCats = $mySqli->query("SELECT CategoryID, ProductID FROM ProductsCategories"); // productCats: productCategories
    
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

<div class='wrap'>
    <div class='container-fluid'>

        <div id="manageProductsByCatContainer" class="span12">
            <div class="span3" ></div>
    <form id="frmChangeProdsInCats" action="#" method="POST">
        <input id="changedChkBoxes" type="hidden" name="changedChkBoxes" value="" />
    </form>
    
    <table border="1">
        <?php
            $prodsInCats = array();

            while($row = $productCats->fetch_assoc()) {
                $prodsInCats[$row["ProductID"] . "," . $row["CategoryID"]] = '';
            }

            echo "<tr><td></td>";
            while($row = $categories->fetch_assoc()) {
                array_push($categoryIDs, $row["CategoryID"]);
                echo "<td>" . $row["CategoryID"] . "-" . $row["CategoryName"] . "</td>";
            }
            echo "</tr>";

            while($row = $products->fetch_assoc()) {
                $pID = $row["ProductID"];

                echo "<tr>";
                echo "<td>" . $pID . "-" . $row["ProductName"] . "</td>";

                for ($i = 0; $i < count($categoryIDs); $i++) {
                    $checked = isset($prodsInCats[$row["ProductID"] . "," . $categoryIDs[$i]]) ? "checked" : "";
                    
                    echo "<td><input type='checkbox' " .
                                    "id='chkProdInCat_" . $pID . "_" . $categoryIDs[$i] . "' " .
                                    "name='chkProdInCat_" . $pID . "," . $categoryIDs[$i] . "' " . 
                                    "onclick='AddModifiedItem(" . $pID . ", " . $categoryIDs[$i] . ")' " . 
                                    $checked . " /></td>";
                }

                echo "</tr>";
            }
        ?>
    </table><br />
    <input type="button" value="Confirmer" onclick="SendChangedData()">
</div>
    </div>
</div>

<script type="text/javascript">
    var prodsInCat = new Array();
    
    function SendChangedData() {
        var ctb = document.getElementById('changedChkBoxes').value; // ctb: changed text boxes
        
        for (var key in prodsInCat) {
            if (ctb !== "")
                ctb += ";";
            ctb += key + "_" + prodsInCat[key];
        }
        
        document.getElementById("changedChkBoxes").value = ctb;
        
        document.getElementById("frmChangeProdsInCats").submit();
    }
    
    function AddModifiedItem(productID, categoryID) {
        var newValue = document.getElementById('chkProdInCat_' + productID + '_' + categoryID).checked ? "Add" : "Delete";
        
        if (prodsInCat[productID + '_' + categoryID] === undefined)
            prodsInCat[productID + '_' + categoryID] = newValue;
        else
            delete prodsInCat[productID + '_' + categoryID]
    }
</script>