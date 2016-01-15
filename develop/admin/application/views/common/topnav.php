<nav class="navbar navbar-default navbar-fixed-top layout_header" role="navigation">
  	<div class="container-fluid">
	    <div class="navbar-header" style="margin-left:18px;">
	    	<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src = "<?php echo base_url('static/img/jiebao.png');?>" height = "30px"/></a>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      	<ul class="nav navbar-nav">
			  <?php 
	          		if(isset($topnav)){
	          			foreach ($topnav as $nav){
	          				echo "<li class='top_nav_li'><a href='$nav[url]'>$nav[content]</a></li>";
	          			}
	          		}
	          ?>
	      	</ul>
	      	<ul class="nav navbar-nav navbar-right">
	        	<li>
	        		<a href="<?php echo site_url('auth/logout'); ?>">注销</a>
	        	</li>
	      	</ul>
	    </div>
  	</div>
</nav>