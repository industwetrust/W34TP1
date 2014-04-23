<?php
  class ProductOrder
  {
    public $ProductID;
    public $Quantity;
        
    function __construct($productID, $quantity)
    {
      $this->ProductID = $productID;
      $this->Quantity = $quantity;
    }
  }
        
  class Basket
  {
    private $_ProductOrders;
    
    function AddProductOrder($productID, $quantity) { // Si le produit est déjà dans le panier, la nouvelle quantité remplace l'ancienne quantité.
      if ($this->IsProductInBasket($productID)) {
        $this->UpdateProductQuantity($productID, $quantity);
      }
      else {
        array_push($this->_ProductOrders, new ProductOrder($productID, $quantity));
      }
    }
    
    function RemoveProductOrder($productID) {
      for ($i = count($this->_ProductOrders)-1; $i >= 0; $i--) {
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
        if ($po->ProductID == $productID) { return true; }
      }
      
      return false;
    }
    
    function GetProductOrders() {
      return $this->_ProductOrders;
    }
  }
?>