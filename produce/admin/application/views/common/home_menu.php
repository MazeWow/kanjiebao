<div class="nav-vertical">
        <ul class="accordion">
        	<?php 
        		$side_nav_str = '';
        		$pannel 	= 	$sidenav['pannel'];
        		$functions 	=	$sidenav['functions'];
        		$pannel_num =	sizeof($pannel);
        		for ($i = 0;$i<$pannel_num;$i++){
        			$side_nav_str .= "<li>";
        			$side_nav_str .="<a href='#one'>$pannel[$i]<span class='caret'></span></a>";
        			$side_nav_str .="<ul class='sub-menu'>";
        			foreach ($functions[$i] as $function){
        				$side_nav_str .= "<li><a href='{$function['url']}' >$function[content]</a></li>";
        			}
        			$side_nav_str .= '</ul></li>';
        			
        		}
        		echo $side_nav_str;
        	?>
        </ul>
</div>






