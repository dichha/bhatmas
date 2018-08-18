<?php
$cat1=$cat2=$cat3=$cat4="";
if(isset($_GET['cat'])){
	if($_GET['cat'] == "electronics"){
	$cat1 = "active";
}else if($_GET['cat'] == 'clothes'){
	$cat2 = "active";
}else if($_GET['cat'] == 'books'){
	$cat3 = "active";
}else if($_GET['cat'] == 'miscellaneous'){
	$cat4 = "active";
}

}
?>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?cat=electronics");?>" class="list-group-item <?php echo $cat1;?>">Electronics</a>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?cat=clothes");?>" class="list-group-item <?php echo $cat2;?>">Clothes</a>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?cat=books");?>" class="list-group-item <?php echo $cat3;?>">Books</a>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?cat=miscellaneous");?>" class="list-group-item <?php echo $cat4;?>">Miscellaneous</a>