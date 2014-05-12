<!--Cette page permet de dénifir les catégories de produit-->

<?php
    header ('charset=utf-8');

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

    if (isset($_POST)) {
        $toAdd = array();       // Catégories à ajouter,
        $toModify = array();    // ...          modifier,
        $toDelete = array();    // ...          détruire
        
        // Vérifie ce qui est à modifier, détruire, ajouter
        foreach(array_keys($_POST) as $key) {
            if (substr($key, 0, 17) === "chkModifyCategory") {
                array_push($toModify, explode("chkModifyCategory", $key)[1]);
            }
            else if (substr($key, 0, 17) === "chkDeleteCategory") {
                array_push($toDelete, explode("chkDeleteCategory", $key)[1]);
            }
            else if (substr($key, 0, 14) === "chkAddCategory") {
                array_push($toAdd, explode("chkAddCategory", $key)[1]);
            }
        }
        
        // Updates
        if (count($toModify) > 0) {
            $okItemsCount = 0;
            
            for ($i = 0, $lim = count($toModify); $i < $lim; $i++) {
                $id = $toModify[$i];
                
                if ($_POST["txtCategoryName" . $id] == "" || $_POST["txtImageURL" . $id] == "") {
                    echo "<div style='color:red;'>La catégorie " . $id . " n'a pas pu être modifié car le nom et/ou l'Url de l'image est manquant.</div>";
                }
                else {
                    $query = "UPDATE categories SET " . 
                             "CategoryName='" . $_POST["txtCategoryName" . $id] . "', " . 
                             "Description='" . $_POST["txtCategoryDesc" . $id] . "', " . 
                             "ImageURL='" . $_POST["txtImageURL" . $id] . "' " . 
                             "WHERE CategoryID = " . $id . ";";
                    
                    $mySqli->query($query);
                    
                    if ($mySqli->affected_rows == 1) {
                        $okItemsCount++;
                    }
                }
            }
            
            if ($okItemsCount > 0) {
                echo "<div style='color: green;'>" . $okItemsCount . " lignes sur " . count($toModify) . " modifiées avec succès!</div>";
            }
        }
        
        // Deletes
        if (count($toDelete) > 0) {
            $query = "DELETE FROM categories WHERE CategoryID IN (";
            for ($i = 0, $lim = count($toDelete); $i < $lim; $i++) {
                $query .= $toDelete[$i];
                
                if ($i < $lim - 1) {
                    $query .= ", ";
                }
            }
            
            $query .= ");";

            $mySqli->query($query);

            if ($mySqli->affected_rows == count($toDelete)) {
                echo "<div style='color: green;'>" . $mySqli->affected_rows . " lignes détruite avec succès!</div>";
            }
            else {
                echo "<div style='color: red;'>" . $mySqli->affected_rows . " lignes détruite sur " . count($toDelete) . ". Err msg: " . $mySqli->error . "</div>";
            }
        }
        
        // Inserts
        if (count($toAdd) > 0) {
            $okItemsCount = 0;
            $query = "INSERT INTO categories (CategoryName, Description, ImageURL) VALUES ";
            for ($i = 0, $lim = count($toAdd); $i < $lim; $i++) {
                $id = $toAdd[$i];

                if ($_POST["txtCategoryName" . $id] == "" || $_POST["txtImageURL" . $id] == "") {
                    echo "<div style='color:red;'>La catégorie " . $id . " n'a pas pu être ajouté car le nom et/ou l'Url de l'image est manquant.</div>";
                }
                else {
                    if ($okItemsCount++ > 0) {
                        $query .= ", ";
                    }
                    
                    $query .= "('" . $_POST["txtCategoryName" . $id] . "', '" .
                                     $_POST["txtCategoryDesc" . $id] . "', '" . 
                                     $_POST["txtImageURL" . $id] . "')";
                }
            }
            
            if ($okItemsCount > 0) {
                $query .= ";";
                
                $mySqli->query($query);
                
                if ($mySqli->affected_rows == $okItemsCount) {
                    echo "<div style='color: green;'>" . $mySqli->affected_rows . " lignes ajouté avec succès!</div>";
                }
                else {
                    echo "<div style='color: red;'>" . $mySqli->affected_rows . " lignes ajouté sur " . $okItemsCount . ". Err msg: " . $mySqli->error . "</div>";
                }
            }
        }
    }
    
    $getCategoriesQuery = "SELECT c.CategoryID, c.CategoryName, c.Description, c.ImageURL, COUNT(pc.ProductID) productCount " . 
                          "FROM categories c " .
                          "LEFT JOIN productsCategories pc " .
                          "ON c.CategoryID = pc.CategoryID " .
                          "GROUP BY c.CategoryID, c.CategoryName, c.Description, c.ImageURL, pc.CategoryID";
    
    $categories = $mySqli->query($getCategoriesQuery);
?>

<div id="manageProductCategoriesContainer" style="width: 1100px; margin: 0px auto;">
    <form action="#" method="POST">
        <table border="1">
            <tr>
                <td>ID</td>
                <td>Nom de catégorie</td>
                <td>Description</td>
                <td>Compte produits</td>
                <td>Nom image</td>
                <td>Image</td>
                <td>Ajouter</td>
                <td>Modifier</td>
                <td>Détruire</td>
    <!--                <td>Message</td>-->
            </tr>
            <?php
                while($row = $categories->fetch_assoc()) {
                    $lastCategoryID = $row["CategoryID"];
                    echo "<tr>";
                    echo "<td>" . $lastCategoryID . "</td>";
                    echo "<td><input type='text' name='txtCategoryName" . $lastCategoryID . "' value='" . $row["CategoryName"] . "' /></td>";
                    echo "<td><input type='text' name='txtCategoryDesc" . $lastCategoryID . "' value='" . $row["Description"] . "' /></td>";
                    echo "<td>" . $row["productCount"] . "</td>";
                    echo "<td><input type='text' name='txtImageURL" . $lastCategoryID . "' value='" . $row["ImageURL"] . "' /></td>";
                    echo "<td><img style='width: 64px; height:64px;' src=' " . $PRODUCT_CATEOGORIES_IMG_PATH . $row["ImageURL"] . "'></td>";
                    echo "<td></td>";
                    echo "<td><input type='checkbox' name='chkModifyCategory" . $lastCategoryID . "' value='Modify' /></td>";
                    echo "<td><input type='checkbox' name='chkDeleteCategory" . $lastCategoryID . "' value='Delete' " . ($row["productCount"] > 0 ? "disabled" : "") . "/></td>";
    //                    echo "<td id='msgTD' style='color:red;'></td>";
                    echo "</tr>";
                }

                for ($i = $lastCategoryID+1; $i <= $lastCategoryID + 3; $i++) {
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td><input type='text' name='txtCategoryName" . $i . "' value='" . $row["CategoryName"] . "' /></td>";
                    echo "<td><input type='text' name='txtCategoryDesc" . $i . "' value='" . $row["Description"] . "' /></td>";
                    echo "<td></td>";
                    echo "<td><input type='text' name='txtImageURL" . $i . "' value='" . $row["ImageURL"] . "' /></td>";
                    echo "<td></td>";
                    echo "<td><input type='checkbox' name='chkAddCategory" . $i . "' value='Add' /></td>";
                    echo "<td></td>";
                    echo "<td></td>";
    //                    echo "<td id='msgTD' style='color:red;'></td>";
                    echo "</tr>";
                }
            ?>
        </table><br />
        <input type="submit" value="Confirmer">
    </form>
</div>