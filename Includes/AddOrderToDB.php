<?php
    if (isset($_POST)) { // Met à jour le panier avant de faire la commande.
        if (!isset($_SESSION["Basket"])) {
            $_SESSION["Basket"] = new Basket();
        }
    
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php
        
        foreach(array_keys($_POST) as $key) {
            $productID = explode("txtQuantity", $key)[1];
            $_SESSION["Basket"]->AddProductOrder($productID, $_POST[$key]); // Basket->AddProductOrder met à jour la quantité si le produit est déjà dans le panier et enlève le produit si la quantité est 0.
        }
        
        if ($_SESSION["Basket"]->GetDiffProductCount() == 0) {
            echo "<div>Votre panier est vide! Cliquez <a href='index.php?page=Produits'>ici</a> pour visiter le catalogue</div>";
        }
        else {
            if (!empty($_SESSION["login"])) {
                $customerID = $mySqli->query("SELECT CustomerID FROM Customers WHERE Username = '" . $_SESSION["login"] . "'")->fetch_assoc()["CustomerID"];
                
                $queryResult = $mySqli->query("SELECT AddressID FROM Addresses WHERE ShortName = '".$_POST["txtShipper"]."' AND CustomerID = '" . $customerID . "'");
                $shippingAddressID = $queryResult->num_rows > 0 ? $queryResult->fetch_assoc()["AddressID"] : "NULL";
                
                $queryResult = $mySqli->query("SELECT AddressID FROM Addresses WHERE ShortName = '".$_POST["txtbilling"]."' AND CustomerID = '" . $customerID . "'");
                $billingAddressID = $queryResult->num_rows > 0 ? $queryResult->fetch_assoc()["AddressID"] : "NULL";

                $mySqli->query("INSERT INTO Orders (CustomerID, BillingAddress, ShippingAddress, OrderDate) VALUES ($customerID, $shippingAddressID, $billingAddressID, CURDATE())"); echo $mySqli->error;
                $orderID = $mySqli->query("SELECT OrderID FROM Orders ORDER BY OrderID DESC LIMIT 1")->fetch_assoc()["OrderID"];
                
                $query = "INSERT INTO OrderDetail (OrderID, ProductID, Quantity) VALUES ";
                $pOrders = $_SESSION["Basket"]->GetProductOrders();
                for ($i = 0; $i < count($pOrders); $i++) {
                    if ($i > 0) {
                        $query .= ", ";
                    }
                    $po = $pOrders[$i];
                    $query .= "($orderID, $po->ProductID, $po->Quantity)";
                }
                $query .= ";";

                $mySqli->query($query);

                if ($mySqli->affected_rows > 0) {
                    echo "<div style='color:green;'>Votre commande a été complété avec succès! Cliquez <a>ici</a> pour accéder à vos commandes et entrer vos informations de livraison et de paiement.</div>";
                    $_SESSION["Basket"] = new Basket();
                }
                else {
                    echo "<div style='color:red;'>Une erreur s'est produite: $mySqli->error </div>";
                }
            }
            else {
                echo "<div style='color:darkred;'>Vous n'êtes pas connecter. Pour Confirmer votre commande, veuillez vous <a class='modal_trigger' style='color:blue;' href='#modal'>identifier</a> ou <a class='modal_trigger' style='color:blue;' href='#modal'>créer un compte</a>.</div>";
            }
        }
    }
?>