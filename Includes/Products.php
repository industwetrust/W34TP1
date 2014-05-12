<?php // Constantes
    $ITEMS_SHOWN_PER_PAGE = 16;
    $ITEMS_SHOWN_PER_ROW = 4;
    $ITEM_WIDTH = 300;
    $ITEM_HEIGHT = 243;
?>

<?php
    if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
    
    $page = empty($_GET["PageN"]) ? 0 : $_GET["PageN"];
    // TODO: Dans le cas où $page n'est pas un entier positif, le changer en 0
        
    echo "<div class='wrap'>";
    echo "<div class='container inner_content'";
    echo "<div class='row'>";
    echo "<div class='projects isotope' style='overflow: hidden; position: relative; height: 729px;'>";
    
    if (!isset($_GET["Category"])) {
        $categories = $mySqli->query("SELECT * FROM Categories LIMIT " . ($ITEMS_SHOWN_PER_PAGE * $page) . " , " . $ITEMS_SHOWN_PER_PAGE);
        
        $itemNumber = 0;
        
        while($row = $categories->fetch_assoc()) {
            $posX = ($itemNumber % $ITEMS_SHOWN_PER_ROW) * $ITEM_WIDTH;
            $posY = floor($itemNumber / 4) * $ITEM_WIDTH;
            echo "<div class='span3 element category01 isotope-item' data-category='category01' style='position: absolute; left: 0px; top: 0px; -webkit-transform: translate3d(" . $posX . "px, " . $posY . "px, 0px);'>";
            
                echo "<div class='hover_img'>";
                    echo "<a href='index.php?page=Produits&Category=" . $row["CategoryID"] . "' class='preloader' style='background-image: none; background-position: initial initial; background-repeat: initial initial;'>";
                        echo "<img src='img/categories/" . $row["ImageURL"] . "' alt style='visibility: visible; opacity: 1;'";
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
    }
    else {
        $products = $mySqli->query("SELECT DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, MIN(pi.ImageURL) " .
                                   "FROM ProductsCategories pc " .
                                   "INNER JOIN Products p " .
                                   "ON pc.ProductID = p.ProductID " .
                                   "INNER JOIN ProductImages pi " .
                                   "ON pi.ProductID = p.ProductID " .
                                   "WHERE pc.CategoryID = " . $_GET["Category"] .
                                   " GROUP BY p.ProductID, p.ProductName, p.Price, p.UnitsInStock");
        
        $itemNumber = 0;
        echo "<div id='itemsContainer'>";
        while($row = $products->fetch_assoc()) {
            if ($itemNumber++ % $ITEMS_SHOWN_PER_ROW == 0) { echo "<div class='itemRow'>"; }
            echo "<div class='itemContainer'>";
            
            echo "<div class='itemImageContainer'><img class='itemImage' src='" . $row["pi.ImageURL"] . "' /></div>";
            if ($row["p.UnitsInStock"] > 0) {
                echo "<div>Acheter: <input type='text' name='txtQuantity" . p.ProductID . "'/></div>";
            }
            else {
                echo "<div style='color:red;'>Éventaire vide!</div>";
            }
            
            echo "</div>";
            if ($itemNumber % $ITEMS_SHOWN_PER_ROW == 0) { echo "</div>"; }
        }
        
        if ($itemNumber % $ITEMS_SHOWN_PER_ROW != 0) { echo "</div>"; }
        echo "</div>";
    }
    
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
?>