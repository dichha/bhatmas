<?php  
if(!isset($_SESSION)){
  session_start();
}
include 'address.php';
require_once 'model/user.php';
require_once 'model/order.php';
$shop_quantity = 0;
$order_request = 0;
/* for number of shopping items in basket*/
if(!empty($_SESSION['purchase_cart'])){  
    $num_buy_item = count($_SESSION['purchase_cart']);
    $shop_quantity = $shop_quantity + $num_buy_item; 
}

if(!empty($_SESSION['rent_cart'])){
    $num_rent_item = count($_SESSION['rent_cart']);
    $shop_quantity = $shop_quantity + $num_rent_item;
}

//for counting number of order requests
if(isset($_COOKIE['login'])){
  $order1 = new Order();
  $user->get_userid();
  $order_request = $order1->count_request($user->userID);
}

?>
<div class="navbar-wrapper">
      <!-- <div class="container"> -->

        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class = "menu">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo $address['home'];?>">Bhatmas<br>
              <small style="font-size:13px">Solution Within Us</small></a>

            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <?php
                    if ((isset($_COOKIE['login']))===true) {                       
                 ?>
                <!-- <li class="<?php //echo $index_active;?>"><a href="<?php //echo $address['home'];?>">Home</a></li> -->
                <li class="dropdown <?php echo $shop_active;?>" >
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Shop <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['buy'];?>">Buy</a></li>
                    <li><a href="<?php echo $address['item_form'];?>">Sell</a></li>
                    <li><a href="<?php echo $address['rent'];?>">Rent</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo $login_active; ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucfirst($user->Username);?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['account'];?>">My Account</a></li>
                    <li><a href="<?php echo $address['logout'];?>">Log Out</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo $info_active;?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">Info<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['about'];?>">About</a> </li>               
                    <li><a href="<?php echo $address['info'];?>">Shop Info</a></li>
                  </ul>
                </li>
                  <?php                  
                } 
                   else{
                        ?>                                              
                <!-- <li class="<?php //echo $index_active;?>"><a href="<?php //echo $address['home'];?>">Home</a></li> -->
                <li class="dropdown <?php echo $shop_active;?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['buy'];?>">Buy</a></li>
                    <li><a href="<?php echo $address['item_form'];?>">Sell</a></li>
                    <li><a href="<?php echo $address['rent'];?>">Rent</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo $login_active; ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">Login<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['login'];?>">Login</a></li>
                    <li><a href="<?php echo $address['signup'];?>">Signup</a></li>
                  </ul>
                </li>                
                <li class="dropdown <?php echo $info_active;?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">Info<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['about'];?>">About</a> </li>               
                    <li><a href="<?php echo $address['info'];?>">Shop Info</a></li>
                  </ul>
                </li>                                        
                   <?php
                  }
                  ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
               <li><a data-toggle="tooltip" title="My Basket" href="<?php echo $address['basket'];?>">
                <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<span class="label label-info"><?php echo $shop_quantity; ?></span>
              </a></li>
              <li>
                <?php
                if(isset($_COOKIE['login'])){
                  ?><li><a data-toggle="tooltip" title="Customer Order" href="<?php echo $address['order_request']; ?>">
                <span class="glyphicon glyphicon-envelope"></span>&nbsp;<span class="label label-info"><?php echo $order_request; ?></span>
              </a></li>
              <li>
                  <?php
                }
                ?>
              
             
              </ul>
              
            </div>
          </div>
          </div>
        </nav>

    <!--   </div> -->
    </div>
  
