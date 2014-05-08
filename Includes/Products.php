<?php // Constantes
    $ITEMS_SHOWN_PER_PAGE = 16;
    $ITEMS_SHOWN_PER_ROW = 4;
?>

<?php
    if (!isset($_SESSION["Basket"])) {
        $_SESSION["Basket"] = new Basket();
    }

    $mySqli = new mysqli("localhost", "root", "", "tpw34");
    
    $page = empty($_GET["Page"]) ? 0 : $_GET["Page"];
    // TODO: Dans le cas où $page n'est pas un entier positif, le changer en 0
    
    if (!isset($_GET["Category"])) {
        $categories = $mySqli->query("SELECT * FROM Categories LIMIT " . ($ITEMS_SHOWN_PER_PAGE * $page) . " , " . $ITEMS_SHOWN_PER_PAGE);
        
        $itemNumber = 0;
        echo "<table style='margin: 0px auto; width: 512px;'>";
        while($row = $categories->fetch_assoc()) {
            if ($itemNumber++ % $ITEMS_SHOWN_PER_ROW == 0) { echo "<tr>"; }
            echo "<td>";
            
            echo "<div class='itemImageContainer'><img class='itemImage' src='img/categories/" . $row["ImageURL"] . "' /></div>";
            
            echo "</td>";
            if ($itemNumber % $ITEMS_SHOWN_PER_ROW == 0) { echo "</tr>"; }
        }
        
        if ($itemNumber % $ITEMS_SHOWN_PER_ROW != 0) { echo "</tr>"; }
        echo "</table>";
    }
    else {
        $products = $mySqli->query("SELECT DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, MIN(pi.ImageURL) " .
                                   "FROM ProductsCategories pc " .
                                   "INNER JOIN Products p " .
                                   "ON pc.ProductID = p.ProductID " .
                                   "INNER JOIN ProductImages pi " .
                                   "ON pi.ProductID = p.ProductID " .
                                   "WHERE pc.CategoryID = " . $_GET["Category"]) .
                                   "GROUP BY p.ProductID, p.ProductName, p.Price, p.UnitsInStock";
        
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
    
    // Version avec divs
//    if (!isset($_GET["Category"])) {
//        $categories = $mySqli->query("SELECT * FROM Categories LIMIT " . ($ITEMS_SHOWN_PER_PAGE * $page) . " , " . $ITEMS_SHOWN_PER_PAGE);
//        
//        $itemNumber = 0;
//        echo "<div id='itemsContainer'>";
//        while($row = $categories->fetch_assoc()) {
//            if ($itemNumber++ % $ITEMS_SHOWN_PER_ROW == 0) { echo "<div class='itemRow'>"; }
//            echo "<div class='itemContainer'>";
//            
//            echo "<div class='itemImageContainer'><img class='itemImage' src='img/categories/" . $row["ImageURL"] . "' /></div>";
//            
//            echo "</div>";
//            if ($itemNumber % $ITEMS_SHOWN_PER_ROW == 0) { echo "</div>"; }
//        }
//        
//        if ($itemNumber % $ITEMS_SHOWN_PER_ROW != 0) { echo "</div>"; }
//        echo "</div>";
//    }
//    else {
//        $products = $mySqli->query("SELECT DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, MIN(pi.ImageURL) " .
//                                   "FROM ProductsCategories pc " .
//                                   "INNER JOIN Products p " .
//                                   "ON pc.ProductID = p.ProductID " .
//                                   "INNER JOIN ProductImages pi " .
//                                   "ON pi.ProductID = p.ProductID " .
//                                   "WHERE pc.CategoryID = " . $_GET["Category"]) .
//                                   "GROUP BY p.ProductID, p.ProductName, p.Price, p.UnitsInStock";
//        
//        $itemNumber = 0;
//        echo "<div id='itemsContainer'>";
//        while($row = $products->fetch_assoc()) {
//            if ($itemNumber++ % $ITEMS_SHOWN_PER_ROW == 0) { echo "<div class='itemRow'>"; }
//            echo "<div class='itemContainer'>";
//            
//            echo "<div class='itemImageContainer'><img class='itemImage' src='" . $row["pi.ImageURL"] . "' /></div>";
//            if ($row["p.UnitsInStock"] > 0) {
//                echo "<div>Acheter: <input type='text' name='txtQuantity" . p.ProductID . "'/></div>";
//            }
//            else {
//                echo "<div style='color:red;'>Éventaire vide!</div>";
//            }
//            
//            echo "</div>";
//            if ($itemNumber % $ITEMS_SHOWN_PER_ROW == 0) { echo "</div>"; }
//        }
//        
//        if ($itemNumber % $ITEMS_SHOWN_PER_ROW != 0) { echo "</div>"; }
//        echo "</div>";
//    }
?>