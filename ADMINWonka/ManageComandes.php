<?php
    if(!isset($_SESSION["nom"])){
               echo '<script language="Javascript">
                <!--
                document.location.replace("index.php");
                // -->
                </script>';
    }

    $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Constantes déclaré au haut de index.php

if (isset($_POST)) {
        $toSend = array();       // comands à envoyeer à ajouter,
//        $toModify = array();    // ...          modifier,
//        $toDelete = array();    // ...          détruire
        
        // Vérifie ce qui est à modifier, détruire, ajouter
        foreach(array_keys($_POST) as $key) {
            if (substr($key, 0, 12) === "SendCategory") {
                array_push($toSend, explode("chkModifyCategory", $key)[1]);
            }
//            else if (substr($key, 0, 17) === "chkDeleteCategory") {
//                array_push($toDelete, explode("chkDeleteCategory", $key)[1]);
//            }
//            else if (substr($key, 0, 14) === "chkAddCategory") {
//                array_push($toAdd, explode("chkAddCategory", $key)[1]);
//            }
        }
        if (count($toSend) > 0) {
            $okItemsCount = 0;
            for ($i = 0, $lim = count($toSend); $i < $lim; $i++) {
                $id = $toSend[$i];
                $query = "UPDATE Orders SET Shipped = '".$i."' , ShipDate = '".date("Y-m-d H:i:s")."'";
                $mySqli->query($query);
                if ($mySqli->affected_rows == 1) {
                    $okItemsCount++;
                }
            }
        if ($okItemsCount > 0) {
            echo "<div style='color: green;'>" . 
                    $okItemsCount . " lignes sur " . count($toSend) . " modifiées avec succès!</div>";
        }
    }
}


?>



<div class="row">
    <div class="span11">
        <div class="span3">
            <img src='img/Rosechoc.jpg' />
        </div>
        <div class="span7">
          <h2>Nouvelles Commandes</h2>
    <?php 
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $query = "SELECT o.OrderID, o.OrderDate, p.ProductName, p.Price, od.Quantity, "
                 . " c.CustomerID FROM orders o INNER JOIN orderdetail od "
                 . "ON o.OrderID = od.OrderId INNER JOIN products p ON od.ProductID = p.ProductID "
                 . "INNER JOIN customers c ON o.CustomerID = c.CustomerID where "
                 . "o.Shipped = 0 ORDER BY o.orderID";
        $result2 = $mySqli->query($query);
        $lastOrderID = -1;
        $totalOld = 0;
        while($ligne = $result2->fetch_assoc()){
            
            if($ligne["OrderID"] > $lastOrderID){
                if($lastOrderID == -1){
                    echo "<form action='#' method='POST'>";
                    echo "<table border='1'>";
                }
                else{ 
    ?>
          
                        <tr>
                            <th colspan='4' style='text-align:right;'>Total :</th>
                            <th><?= $totalOld ?></th>
                        </tr>
                    </table>
                    <br />
                    <table border='1'>
        <?php   } ?>
                    
                        <tr>
                            <th>Facture No : <?= $ligne["OrderID"]?></th>
                            <th>Date : <?= $ligne["OrderDate"] ?></th>
                            <th colspan="2"> Envoyée
                                <input type='checkbox' name='SendCategory<?= $ligne["OrderID"]?>' value='send' />
                            </th>
                        </tr>
                        <tr>
                            <td></td>
                            <th>Nom Prod.</th>
                            <th>Quantité  : </th>
                            <th>Price  :</th>
                            <th>Soustotal  :</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?= $ligne["ProductName"]?></td>
                            <td><?= $ligne["Quantity"] ?></td>
                            <td><?= $ligne["Price"] ?></td>
                            <td><?= $ligne["Price"] * $ligne["Quantity"]  ?></td>
                        </tr>
            <?php
                $lastOrderID = $ligne["OrderID"];
                $totalOld = 0;
                $totalOld += $ligne["Price"] * $ligne["Quantity"];
            }else{ $totalOld += $ligne["Price"] * $ligne["Quantity"]; ?>
                    <tr>
                        <td></td>
                        <td><?= $ligne["ProductName"]?></td>
                        <td><?= $ligne["Quantity"] ?></td>
                        <td><?= $ligne["Price"] ?></td>
                        <td><?= $ligne["Price"] * $ligne["Quantity"]  ?></td>
                    </tr>
          <?php
            }
        }
    ?>
                    <tr>
                        <th colspan='4' style='text-align:right;'>Total :</th>
                        <th><?= $totalOld ?></th>
                    </tr>
                </table>
                    <br/>
                    <input type='submit' name='SendButton' value='Mise a Jour' />
            </form>
        </div>
    </div>  
</div>


