
<div class="row">
    <div class="span11">
        <div class="span3">
            <img src='img/Rosechoc.jpg' />
        </div>
        <div class="span7">
          <h2>Anciennes Commandes</h2>
    <?php 
        $mySqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $nomOld =$_SESSION["login"];
        $query = "SELECT o.OrderID, o.OrderDate, p.ProductName, p.Price, od.Quantity, "
                 . " c.CustomerID FROM orders o INNER JOIN orderdetail od "
                 . "ON o.OrderID = od.OrderId INNER JOIN products p ON od.ProductID = p.ProductID "
                 . "INNER JOIN customers c ON o.CustomerID = c.CustomerID where "
                 . "c.Username = '".$nomOld."' ORDER BY o.orderID";
        $result2 = $mySqli->query($query);
        $lastOrderID = -1;
        $totalOld = 0;
        while($ligne = $result2->fetch_assoc()){
            
            if($ligne["OrderID"] > $lastOrderID){
                if($lastOrderID == -1){
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
        </div>
    </div>  
</div>


