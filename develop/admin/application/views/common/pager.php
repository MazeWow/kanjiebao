<div class="col-md-12 text-right">
	<ul class="pagination">
		<?php if (isset($pager)): ?>
		<li class="first "><a href="<?php echo base_url("$url?page_now=1");?>">首页</a></li>
		<li class="prev"><a
			href="<?php echo base_url("$url?page_now=$pager[pre_page]");?>">上一页</a></li>
							<?php foreach ($pager['pages'] as $item): ?>
								<?php if ($item == $pager['page_now']): ?>
									<li class="page active"><a
			href="<?=base_url("$url?page_now=$item")?>"><?=$item?></a></li>
									<?php continue;?>
								<?php endif; ?>
								<li class="page"><a href="<?=base_url("$url?page_now=$item")?>"><?=$item?></a></li>
							<?php endforeach;?>
							<li class="next"><a
			href="<?php echo base_url("$url?page_now=$pager[next_page]")?>">下一页</a></li>
		<li class="last"><a
			href="<?php echo base_url("$url?page_now=$pager[total_pages]")?>">尾页</a></li>
			<?php endif; ?>
	</ul>
</div>
