<?php
require_once 'model/user.php';
require_once 'address.php';
$user = new User();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bhatmas | Index</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
    <script src="js/additional.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#search_form').validate({
                //setting up the rules for form serach validation
                rules: {
                    search_item:{required:true}
                },
                messages: {
                    search_item: {required: "Please enter item"}
                }
            });
        });
    </script>

</head>

<body>
    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times" style="color:#21610B;"></i></a>
            <li class="sidebar-brand">
                <a href="<?php echo $address['home']; ?>" onclick=$ ( "#menu-close").click();>Bhatmas</a>
            </li>

            <li>
                <a href="<?php echo $address['home']; ?>" onclick=$ ( "#menu-close").click();>Home</a>
            </li>

            <li class="dropdown <?php echo $shop_active; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Shop <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $address['buy']; ?>">Buy</a></li>
                <li><a href="<?php echo $address['item_form']; ?>">Sell</a></li>
                <li><a href="<?php echo $address['rent']; ?>">Rent</a></li>
              </ul>
            </li> 
            <?php if (isset($_COOKIE['login'])===true){
                ?>
                 <li class="dropdown <?php echo $login_active; ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucfirst($user->Username);?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $address['account'];?>">My Account</a></li>
                    <li><a href="<?php echo $address['logout'];?>">Log Out</a></li>
                  </ul>
                </li>

                <?php
                        
                    }else{
                        ?>
                          <li class="dropdown <?php echo $login_active; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">Login<span class="caret"></span></a>
                            <ul class="dropdown-menu">                    
                    <li><a href="<?php echo $address['login'];?>">Login</a></li>
                    <li><a href="<?php echo $address['signup'];?>">Signup</a></li>
                </ul>
            </li>

                        <?php
                    }
            ?>
          
             <li class="dropdown <?php echo $info_active;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">Info<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $address['about'];?>">About</a> </li>               
                <li><a href="<?php echo $address['info'];?>">Shop Info</a></li>
              </ul>
            </li>                        
        </ul>
    </nav>


     <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h2>A Niche Market, Bhatmas</h2>
            <h3>Buy, Sell &amp; Rent Within Your Budget</h3>
            
            <div class="col-sm-12">  

                <form id="search_form" method="POST" action="shop/search_form.php">
                    
                        <div class="col-sm-2"></div>
                        
                            <label for="search" class="col-sm-1 control-label" style="padding-right:0px; padding-top:5px; font-weight:normal; font-size:15px; color:#21610B; ">Find me a</label>


                            <div class="col-sm-5" style="padding-left:0px; padding-right: 0px; padding-bottom:5px;">                               
                                <input type="text" id="search" name="search_item" class="form-control" placeholder="e.g. mo:mo steamer, jantar ornament, dhaka topi"/>
                            </div>                                                              
                            <div class="col-sm-2" style="padding-left:0px; padding-right: 0px">
                                <select name="category" class="selectpicker form-control">
                                    <option value="All Categories" selected="selected">All Categories</option>
                                    <option value="Books">Books</option>
                                    <option value="Clothes">Clothes</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Miscellaneous">Miscellaneous</option>                                       
                                </select>
                            </div>
                        
                           <div class="col-sm-2"></div>
                
            
            </form>
        </div><!--/.col-sm-12-->     
        <button type="submit" class="btn btn-dark btn-lg" form="search_form" name="search_button" value="Search">Search</button>
        </div>
    </header>
    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    </script>
</body>

</html>
