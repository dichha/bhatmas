<?php
session_start();
?>

<div class="well">
    <form method="post" action="my_basket.php" method="POST">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                </tr>
            </thead>            
            <tbody>
            <?php
            //checking if shopping cart is not empty
                if(!empty($_SESSION['purchase_cart'])){
                    $_SESSION["total_price"] =0;
                        foreach ($_SESSION['purchase_cart'] as $pID =>$value) {

                    ?>                                
                <tr>
                    <td>
                        <a href=""><img class="img-thumbnail" src="<?php echo $value['image'];?>" alt=""></a>
                        <a href="item_detail.php?pid=<?php echo $pID;?>" style="text-decoration:none;"><?php echo $value['name'];?></a>
                    </td>
                    <td>
                    <select name="item_quantity[<?php echo( $pID);?>]">
                        <option value="<?php echo $value['quantity']; ?>">
                            <?php echo $value['quantity']; ?>
                        </option>
                        <option value="" disabled>--</option>
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4</option>
                        <option value="5"> 5 </option>
                    </select>                         
                    </td>
                    <td>
                        &pound<?php echo $value['price'] ?>                                            
                    </td>
                    <td>
                        &pound<?php echo $value['quantity'] * $value['price'];
                        $_SESSION["total_price"] += $value['quantity'] * $value['price']; ?>                                            
                    </td>
                    <td id = "remove">Remove</td>
                    </tr>
                                    <?php
                    }//iterating through shopping cart ends here

                                  //checking for empty cart ends here
                        }else{
                                  $_SESSION['total_price']=0;

                 } 
                                ?>
                    <tr>
                        <td></td>
                        <td>
                        <div class = "col-sm-4">                                                
                            <input type="submit" name="update_quantity" value="Update Quantity">
                        </div>                                              
                        </td>
                        <td>Total Price</td>
                        <td>
                            &pound<?php echo $_SESSION["total_price"];?>
                        </td>
                        <td></td>
                        </tr>
            </tbody>
        </table>

    </form>
</div>

               