<?php // Constantes
    $ITEMS_SHOWN_PER_PAGE = 16;
    $ITEMS_SHOWN_PER_ROW = 4;
    $ITEM_WIDTH = 300;
    $ITEM_HEIGHT = 273;
?>

<?php
    if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }

    if (!empty($_POST)) {
        foreach(array_keys($_POST) as $txtBox) {
            if (isset($_POST[$txtBox])) {
                $productID = explode("txtAddToCart", $txtBox)[1];
                $quantity = $_POST[$txtBox];
                
                $_SESSION["Basket"]->AddProductOrder($productID, $quantity);
            }
        }
    }
    
    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
    
    $page = empty($_GET["PageN"]) ? 0 : $_GET["PageN"];
    // TODO: Dans le cas où $page n'est pas un entier positif, le changer en 0
    echo "<div class='wrap'>";
    echo "<div class='container inner_content'>";
    echo "<div style='background-image:url(\"Img/Cart.png\"); float:right; margin-bottom:4px; height:48px; width:48px; text-align:center;'>";
        echo "<a style='color:#060; font-size:18px; position:relative; top:10px;'>" . $_SESSION["Basket"]->GetDiffProductCount() . "</a>";
    echo "</div>";
    echo "<div class='row' style='clear:both;'>";
    
    if (!isset($_GET["Category"])) {
        $categories = $mySqli->query("SELECT * FROM Categories WHERE (SELECT COUNT(*) FROM ProductsCategories WHERE CategoryID = Categories.CategoryID)");
        
        $itemNumber = 0;
        
        echo "<div class='projects isotope' style='overflow: hidden; position: relative; height: " . (ceil($categories->num_rows / $ITEMS_SHOWN_PER_ROW) * $ITEM_HEIGHT) . "px;'>";
        
        while($row = $categories->fetch_assoc()) {
            $posX = ($itemNumber % $ITEMS_SHOWN_PER_ROW) * $ITEM_WIDTH;
            $posY = floor($itemNumber / 4) * $ITEM_WIDTH;
            echo "<div class='span3 element category01 isotope-item' data-category='category01' style='position: absolute; left: 0px; top: 0px; -webkit-transform: translate3d(" . $posX . "px, " . $posY . "px, 0px);'>";
            
                echo "<div class='hover_img'>";
                    echo "<a href='index.php?page=Produits&Category=" . $row["CategoryID"] . "' class='preloader' style='background-image: none; background-position: initial initial; background-repeat: initial initial;'>";
                        echo "<img src='img/categories/" . $row["ImageURL"] . "' alt style='visibility: visible; opacity: 1; width: 243px; height: 180px;'";
                    echo "</a>";
                echo "</div>";

                echo "<div class='item_description'>";
                    echo "<h6>";
                        echo "<a>" . $row["CategoryName"] . "</a>";
                    echo "</h6>";

                    echo "<div class='descr'>" . $row["Description"] . "</div>";
            
                echo "</div>";
            
            echo "</div>";
            
            $itemNumber++;
        }
        
        echo "</div>";
    }
    else {
        echo "<form action='#' method='POST'>";
        $products = $mySqli->query("SELECT DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, p.Description, MIN(pi.ImageURL) ImageURL " .
                                   "FROM ProductsCategories pc " .
                                   "INNER JOIN Products p " .
                                   "ON pc.ProductID = p.ProductID " .
                                   "INNER JOIN ProductImages pi " .
                                   "ON pi.ProductID = p.ProductID " .
                                   "WHERE pc.CategoryID = " . $_GET["Category"] .
                                   " GROUP BY p.ProductID, p.ProductName, p.Price, p.UnitsInStock " .
                                   "LIMIT " . ($ITEMS_SHOWN_PER_PAGE * $page) . " , " . $ITEMS_SHOWN_PER_PAGE);
        $itemNumber = 0;
        
        echo "<div class='projects isotope' style='overflow: hidden; position: relative; height: " . (ceil($products->num_rows / $ITEMS_SHOWN_PER_ROW) * $ITEM_HEIGHT + 85) . "px;'>";
        
        while($row = $products->fetch_assoc()) {
            $quantityInBasket = $_SESSION["Basket"]->GetQuantityInBasket($row["ProductID"]);
            $posX = ($itemNumber % $ITEMS_SHOWN_PER_ROW) * $ITEM_WIDTH;
            $posY = floor($itemNumber / 4) * $ITEM_WIDTH;
            echo "<div class='span3 element category01 isotope-item' data-category='category01' style='position: absolute; left: 0px; top: 0px; -webkit-transform: translate3d(" . $posX . "px, " . $posY . "px, 0px);'>";
            
                echo "<div class=''>";
                    echo "<a class='preloader' style='background-image: none; background-position: initial initial; background-repeat: initial initial;'>";
                        echo "<img src='img/Products/" . $row["ImageURL"] . "' alt style='visibility: visible; opacity: 1;'";
                    echo "</a>";
                echo "</div>";

                echo "<div class='item_description'>";
                    echo "<h6>";
                        echo "<a>" . $row["ProductName"] . "</a>";
                    echo "</h6>";

                    echo "<div class='descr'>Prix: " . $row["Price"] . "<br />" . 
                         "Ajouter au panier:<input type'text' name='txtAddToCart" . $row["ProductID"] . "' style='width: 34px; height: 14px;' onkeypress='return IsNumberOrControl(event)' maxLength='4' value='$quantityInBasket' ></div>";
            
                echo "</div>";
            
            echo "</div>";
            
            $itemNumber++;
        }
        
        echo "</div>";
        echo "<div><input type='submit' value='Mettre à jour le panier' style='margin-left: 30px;' /></div>";
        
        $pageCount = ceil($mySqli->query("SELECT COUNT(*) FROM ProductsCategories WHERE CategoryID = " . $_GET["Category"])->fetch_row()[0] / $ITEMS_SHOWN_PER_PAGE);
        $previousPage = $page > 0 ? $page - 1 : 0;
        $nextPage = $page < $pageCount-1 ? $page + 1 : $pageCount-1;
        
        echo "<div class='pageNavigator' style='margin: 10px 0px 0px 30px; color:blue;'>";
            echo "<a style='color:blue;' href='index.php?page=Produits&Category=" . $_GET["Category"] . "&PageN=0' ><< </a>";
            echo "<a style='color:blue;' href='index.php?page=Produits&Category=" . $_GET["Category"] . "&PageN=" . $previousPage . "' >< </a>";
            for ($i = 1; $i <= $pageCount; $i++) {
                echo "<a style='color:blue;' href='index.php?page=Produits&Category=" . $_GET["Category"] . "&PageN=" . ($i-1) . "' >" . $i . " </a>";
            }
            echo "<a style='color:blue;' href='index.php?page=Produits&Category=" . $_GET["Category"] . "&PageN=" . $nextPage . "' >> </a>";
            echo "<a style='color:blue;' href='index.php?page=Produits&Category=" . $_GET["Category"] . "&PageN=" . ($pageCount-1) . "' >>> </a>";
        echo "</div>";
        echo "</form>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
?><script type="text/javascript">
    function IsNumberOrControl(e) {
        var key = window.event ? e.keyCode : e.which;

        return e.keyCode === 8 || e.keyCode === 46 || e.keyCode === 37 || e.keyCode === 39 || e.keyCode >= 48 && key <= 57;
    }
    
//    function CheckModifyChkBox(productID, categoryID) {
//        var newValue = document.getElementById('chkProdInCat_' + productID + '_' + categoryID).checked ? "Add" : "Delete";
//        
//        if (prodsInCat[productID + '_' + categoryID] === undefined)
//            prodsInCat[productID + '_' + categoryID] = newValue;
//        else
//            delete prodsInCat[productID + '_' + categoryID]
//    }
</script>