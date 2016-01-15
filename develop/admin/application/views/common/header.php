<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$title ?></title>
<link rel="shortcut icon" href="/static/img/bitbug_favicon.ico" type="image/x-icon">
<?php $this->load->view('common/js_and_css_include');?>
<style>
	.layout_rightmain .inner {background-color:#F4F4F4;width:100%;height:40px;position:absolute;padding:0px;}
	.nav-vertical{position:fixed;width:180px;height:90%;top:51px;}
	.navbar-header{margin-left:60px;}
	#main_page{padding-left:20px;padding-right:20px;}
	ul.pagination {margin-bottom: 40px;}
</style>
</head>
<body>
<?php $this->load->view('common/topnav'); ?>
<?php $this->load->view('common/home_menu'); ?>


















