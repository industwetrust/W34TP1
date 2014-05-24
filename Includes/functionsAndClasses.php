<?php

class ProductOrder {

    public $ProductID;
    public $Quantity;

    function __construct($productID, $quantity) {
        $this->ProductID = $productID;
        $this->Quantity = $quantity;
    }

}

class Basket {

    private $_ProductOrders;

    function __construct() {
        $this->_ProductOrders = array();
    }

    function AddProductOrder($productID, $quantity) { // Si le produit est déjà dans le panier, la nouvelle quantité remplace l'ancienne quantité. Si la quantité est 0, enlève le produit du panier.
        if ($quantity < 0 || !ctype_digit($quantity)) {
            return;
        }
        $quantity = (int) $quantity; // Enlève les 0 au début;

        if ($quantity == 0) {                                                
            $this->RemoveProductOrder($productID);                                          // Enlève (si la quantité est 0)
        } else if ($this->IsProductInBasket($productID)) {
            $this->UpdateProductQuantity($productID, $quantity);                            // Ajoute (si le produit N'EST PAS DÉJÀ dans panier)
        } else {
            array_push($this->_ProductOrders, new ProductOrder($productID, $quantity));     // Met à jour (si le PRODUIT EST DÉJÀ dans panier)
        }
    }

    function RemoveProductOrder($productID) {
        for ($i = count($this->_ProductOrders) - 1; $i >= 0; $i--) {
            if ($this->_ProductOrders[$i]->ProductID == $productID) {
                array_splice($this->_ProductOrders, $i, 1);
                return;
            }
        }
    }

    function UpdateProductQuantity($productID, $quantity) {
        foreach ($this->_ProductOrders as $po) {
            if ($po->ProductID == $productID) {
                $po->Quantity = $quantity;
                return;
            }
        }
    }

    function IsProductInBasket($productID) {
        foreach ($this->_ProductOrders as $po) {
            if ($po->ProductID == $productID) {
                return true;
            }
        }

        return false;
    }

    function GetQuantityInBasket($productID) {
        foreach ($this->_ProductOrders as $po) {
            if ($po->ProductID == $productID) {
                return $po->Quantity;
            }
        }

        return 0;
    }

    function GetDiffProductCount() { // Retourne le nombre de produits différents
        return count($this->_ProductOrders);
    }

    function GetProductsCount($productID) { // Retourne le nombre totals de produits (et non le nombre de produits différents)
        $count = 0;

        foreach ($this->_ProductOrders as $po) {
            $count += $po->Quantity;
        }

        return $count;
    }

    function GetProductOrders() {
        return $this->_ProductOrders;
    }

    public static function Serialize($basket) {
        $serialized = "";
    
        foreach ($basket->_ProductOrders as $po) {
            if ($serialized != "") {
                $serialized .= ";";
            }
            $serialized .= $po->ProductID . '@' . $po->Quantity;
        }

        return $serialized;
    }
    public static function Unserialize($sBasket) { // sBasket: serializedBasket
        $basket = new Basket();
        
        $pOrders = explode(";", $sBasket); // pOrders: productOrders
        
        foreach ($pOrders as $po) {
            $po = explode("@", $po);
            
            $basket->AddProductOrder($po->ProductID, $po->Quantity);
        }
        
        return $basket;
    }
}

?>