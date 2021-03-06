<?php // Constantes
    $ITEMS_SHOWN_PER_PAGE = 16;
    $ITEMS_SHOWN_PER_ROW = 4;
    $ITEM_WIDTH = 300;
    $ITEM_HEIGHT = 290;

    if (!empty($_POST)) {
        foreach(array_keys($_POST) as $txtBox) {
            if (isset($_POST[$txtBox])) {
                $productID = explode("txtAddToCart", $txtBox)[1];
                $quantity = $_POST[$txtBox];
                
                $_SESSION["Basket"]->AddProductOrder($productID, $quantity);
                echo '<script language="Javascript">
                <!--
                window.location.reload();
                // -->
                </script>';
            }
        }
    }
    
    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
    
    $page = empty($_GET["PageN"]) ? 0 : $_GET["PageN"];
    // TODO: Dans le cas où $page n'est pas un entier positif, le changer en 0
    echo "<div class='wrap'>";
    echo "<div class='container-fluid'>";
    echo "<div class='span12' >";
    
    if (!isset($_GET["Category"]) && !isset($_GET["CustomSearch"])) {
        $categories = $mySqli->query("SELECT * FROM Categories WHERE (SELECT COUNT(*) FROM ProductsCategories WHERE CategoryID = Categories.CategoryID)");
        $catNames = array();
        $catIDs = array();
        
        $itemNumber = 0;
        
        echo "<div class='row' >";
        
        while($row = $categories->fetch_assoc()) {
            array_push($catIDs, $row["CategoryID"]);
            array_push($catNames, $row["CategoryName"]);
            
            ?>
            <div class='span3' data-category='category01'>
                <div class='hover_img'>
                    <a href='index.php?page=Produits&Category=<?= $row["CategoryID"] ?>' >
                        <img src='img/categories/<?= $row["ImageURL"] ?>' alt style='visibility: visible; 
                             opacity: 1; width: 270px; height: 200px;'/>
                    </a>
                </div>
                <div class='item_description'>
                    <h6>
                    <a><?= $row["CategoryName"] ?></a>
                    </h6>

                    <div class='descr'><?= $row["Description"] ?></div>
                </div><br/><br/>
            </div>
            
           <?php
            $itemNumber++;
        }
        
    ?>

<!--	Création du menu pour la recherche de produit de façon personalisée-->
	<div class='span3' data-category='category01' style="padding-left: 2%;">
        <form action='index.php' method='GET'>
            <input type='hidden' name='CustomSearch' value='True'/>
            <input type='hidden' name='page' value='Produits'/>
            <div>Recherche personnalisé:</div>
            <div>Nom: <input type='text' name='txtName' style='width:186px;'/></div>
            <div>Catégorie: 
                <select style='width:173px;' name='selCategory'>
                    <option value='All'>Tous</option>
					<?php 
					for ($i = 0; $i < count($catIDs); $i++) {
						echo "<option value=$catIDs[$i]>$catNames[$i]</option>";
					} ?>
                </select>
            </div>
            <div>Prix maximal: 
                <input type='text' name='txtPrice' value='0.00' onkeypress='return IsNumberOrControl(event)' 
                       style='width:143px;' maxLength='6'/>
            </div>
            <div><input type='submit' value='Rechercher'/></div>
        </form>
	</div>
</div>
<?php
    }
    else {
        echo "<form action='#' method='POST'>";
        
        // Clause WHERE
        $whereClause = "WHERE ";
        if (!empty($_GET["CustomSearch"]) && $_GET["CustomSearch"]) {
            if (!empty($_GET["txtName"])) {
                if ($whereClause != "WHERE ") {
                    $whereClause .= " AND ";
                }
                $whereClause .= "p.ProductName LIKE '%" . $_GET["txtName"] . "%'";
            }
            if (!empty($_GET["selCategory"]) && $_GET["selCategory"] != "All") {
                if ($whereClause != "WHERE ") {
                    $whereClause .= " AND ";
                }
                $whereClause .= "pc.CategoryID = " . $_GET["selCategory"];
            }
            if (!empty($_GET["txtPrice"]) && filter_var($_GET["txtPrice"], FILTER_VALIDATE_FLOAT)) {
                if ($whereClause != "WHERE ") {
                    $whereClause .= " AND ";
                }
                $whereClause .= "p.Price < " . $_GET["txtPrice"];
            }
            
            if ($whereClause == "WHERE ") {
                $whereClause = "";
            }
        }
        else {
            $whereClause .= "pc.CategoryID = " . $_GET["Category"];
        }
        
        // Requête et affichage
        $mainQuery = "SELECT DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, p.Description, p.ImageURL " .
                     "FROM ProductsCategories pc " .
                     "INNER JOIN Products p " .
                     "ON pc.ProductID = p.ProductID ";
        $products = $mySqli->query($mainQuery . $whereClause . " LIMIT " . ($ITEMS_SHOWN_PER_PAGE * $page) . " , " . $ITEMS_SHOWN_PER_PAGE);
                                   
        if ($products->num_rows > 0) {
            $itemNumber = 0;

            echo "<div class='projects isotope' style='overflow: hidden; position: relative; height: " . (ceil($products->num_rows / $ITEMS_SHOWN_PER_ROW) * $ITEM_HEIGHT + 45) . "px;'>";

            while($row = $products->fetch_assoc()) {
                $quantityInBasket = $_SESSION["Basket"]->GetQuantityInBasket($row["ProductID"]);
                $posX = ($itemNumber % $ITEMS_SHOWN_PER_ROW) * $ITEM_WIDTH;
                $posY = floor($itemNumber / 4) * $ITEM_WIDTH;
                echo "<div class='span3 element category01 isotope-item' data-category='category01' style='position: absolute; left: 0px; top: 0px; -webkit-transform: translate3d(" . $posX . "px, " . $posY . "px, 0px);'>";

                    echo "<div class=''>";
                        echo "<a class='preloader' style='background-image: none; background-position: initial initial; background-repeat: initial initial;'>";
                            echo "<img src='img/Products/" . $row["ImageURL"] . "' alt style='visibility: visible; opacity: 1; width: 270px; height: 200px;'";
                        echo "</a>";
                    echo "</div>";

                    echo "<div class='item_description'>";
                        echo "<h6>";
                            echo "<a>" . $row["ProductName"] . "</a>";
                        echo "</h6>";

                        echo "<div class='descr'>Prix: " . $row["Price"] . "<br />" . 
                             "Ajouter au panier: <input type'text' name='txtAddToCart" . $row["ProductID"] . "' style='width: 18px; height: 14px; text-align:right;' onkeypress='return IsNumberOrControl(event)' maxLength='2' value='$quantityInBasket' ></div>";

                    echo "</div>";

                echo "</div>";

                $itemNumber++;
            }

            echo "</div>";
            echo "<div><input type='submit' value='Mettre à jour le panier' style='margin-left: 30px;' /></div>";
            echo "</form>";
            // Pagination
            $pageCount = ceil($mySqli->query("SELECT COUNT(DISTINCT p.ProductID, p.ProductName, p.Price, p.UnitsInStock, p.Description, p.ImageURL) " . 
                                             "FROM ProductsCategories pc " .
                                             "INNER JOIN Products p " .
                                             "ON pc.ProductID = p.ProductID " . $whereClause)->fetch_row()[0] / $ITEMS_SHOWN_PER_PAGE);
            $previousPage = $page > 0 ? $page - 1 : 0;
            $nextPage = $page < $pageCount-1 ? $page + 1 : $pageCount-1;
            
            $customSearchConstraint =   !empty($_GET["CustomSearch"])   ?   "&CustomSearch="   . $_GET["CustomSearch"]   :     "";
            $categoryConstraint =       !empty($_GET["Category"])       ?   "&Category="       . $_GET["Category"]       :     "";
            $nameConstraint =           !empty($_GET["txtName"])        ?   "&txtName="        . $_GET["txtName"]        :     "";
            $selCategoryConstraint =    !empty($_GET["selCategory"])    ?   "&selCategory="    . $_GET["selCategory"]    :     "";
            $priceConstraint =          !empty($_GET["txtPrice"])       ?   "&txtPrice="       . $_GET["txtPrice"]       :     "";
            
            $constraints = $customSearchConstraint . $categoryConstraint . $nameConstraint . $selCategoryConstraint . $priceConstraint;
            
            echo "<div class='pagination' style='margin: 10px 0px 0px 20%; color:blue;'>";
            echo "<ul><li>";
                echo "<li><a href='index.php?page=Produits" . $constraints . "&PageN=0' ><< </a></li>";
                echo "<li><a href='index.php?page=Produits" . $constraints . "&PageN=$previousPage' >< </a></li>";
                for ($i = 1; $i <= $pageCount; $i++) {
                    echo "<li class='active'><a href='index.php?page=Produits" . $constraints . "&PageN=" . ($i-1) . "' >" . $i . " </a></li>";
                }
                echo "<li><a href='index.php?page=Produits" . $constraints . "&PageN=$nextPage' >> </a></li>";
                echo "<li><a href='index.php?page=Produits" . $constraints . "&PageN=" . ($pageCount-1) . "' >>> </a></li></ul>";
            echo "</div>";
            

        }
        else { // Aucun produit trouvé
            
        }
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
?>

<script type="text/javascript">
    function IsNumberOrControl(e) {
        var key = window.event ? e.keyCode : e.which;

        return key=== 8 || key === 46 || key === 37 || key === 39 || key >= 48 && key <= 57;
    }
</script>