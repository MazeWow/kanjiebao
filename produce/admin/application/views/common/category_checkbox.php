<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">品类</p>
</div>
<div class="col-sm-12">
<div class="checkbox">
<?php
//品牌风格
global $CATEGORY;
foreach ($CATEGORY as $key => $value){
	echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
}
?>
</div>
</div>
</div>