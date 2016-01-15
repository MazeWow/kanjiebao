<?php $this->load->view("common/header");?>
</head>
<body >
<div class="head" id="head">
  <a class="pull-left icon-left-a" href="javascript:history.go(-1);"><img class="img-responsive icon-left" src="application/views/inc/img/back_arrow.png"/></a>
  <a class="pull-right icon-right-a" href="user"><img class="img-responsive icon-right" src="application/views/inc/img/user.png"/></a>
  <div class="center"><span class="title title-selected title-center dn" id="title"></span></div>
</div>
<div class="head-blank" id="headBlank"></div>
<div id="districtImgContainer"  class="district-img-container"></div>
<br/>
<div class="mall-header dn" id="mall-header">
  <img src="application/views/inc/img/mall.png" class="mall-header-img"/>
  <span class="mall-header-text">商场</span>
</div>
<div class="flow-container">
  <div class="district-mall-containers">
    <div id="districtMall" class="clearfix district-mall"></div>
  </div>
  <br/>
</div>
<br/>
<div class="act-header dn" id="act-header">
  <img src="application/views/inc/img/bag.png" class="mall-header-img"/>
  <span class="act-header-text">精选活动</span>
</div>
<?php $this->load->view("common/footer");?>