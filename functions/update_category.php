<select name = "category" form-control>
<OPTION value = "<?php echo$product->productInfo['category']; ?>"selected><?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : $product->productInfo['category']; ?></OPTION>
<OPTION value = "Electronics">Electronics</OPTION>
<OPTION value = "Clothes">Clothes</OPTION>
<OPTION value = "Books">Books</OPTION>
<OPTION value = "Miscellaneous">Miscellaneous</OPTION>
</select>