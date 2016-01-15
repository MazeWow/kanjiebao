<?php if(isset($events)):?>
<?php foreach ($events as $event):?>
<div class="act-mall">
	<a href="event?event=<?=$event['event_id']?>" class="act-a">
		<img class="img-responsive act-img" src="<?=$event['event_photo'][0]?>" id="actImg1"></a>
	<a href="district?district=<?=$event['store_info']['district_id']?>" class="district-a">
		<div class="clearfix mall-name">
			<img src="static/img/tag_for_mall.png" class="pull-left">  
			<div class="center mall-name-text"><?=$event['store_info']['district_name']?></div>
		</div>
	</a>
</div>
<div class="store">
	<img class="img-responsive store-image" src="<?=$event['store_info']['brand_logo']?>">
	<img class="img-responsive logo-frame" src="static/img/logo_frame.png">
</div>
<div class="detail">
	<div class="content">
	<div class="act-name" title="<?=$event['event_name']?>">
	<?=$event['event_name']?></div><div class="end-time">剩余<?=$event['event_left_day']?>天</div>
	<div class="store-name"><?=$event['store_info']['store_name']?></div></div>
	<button type="button" class="pull-right collection" onclick="collect(<?=$event['event_id']?>, 1)">
	<img class="img-responsive collection-image" src="static/img/heart.png" id="collectImg1">
	<div class="center collection-number" id="collectionNumber1"><?=$event['event_like_num']?></div></button>
	<div class="clearfix">
	</div>
</div>
<br class="split">
<?php endforeach;?>
<?php endif;?>