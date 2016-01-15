<?php
/*********************街报环境配置***************************/
						
/*
 * @desc				配置说明
 * 
 * API_URL				api 接口地址
 * 
 * MYSQL_USER				MySQL 账号
 * 
 * MYSQL_PASSWORD 			MySQL 密码
 * 
 * MYSQL_DB				数据库
 * 
 * MEMCACHE_HOST			memcache  缓存 host
 * 
 * MEMCACHE_PORT			memcache  缓存 端口
 * 
 * API_ACCESS_CONTROL			允许跨越访问的 url 
 * 
 * 
 * */

/*
 * @desc		生产环境
 * 
 * */

define("API_URL","http://api.kanjiebao.com/");
define('MYSQL_USER','root');
define('MYSQL_PASSWORD','jiebao2015');
define('MYSQL_DB','jiebao_produce');
define('MEMCACHE_HOST','27.0.0.1');
define('MEMCACHE_PORT',11211);
define("API_ACCESS_CONTROL","Access-Control-Allow-Origin:http://admindev.kanjiebao.com");


/*
 * @desc		测试环境
 *
 * */
 
// define("API_URL","http://apidev.kanjiebao.com/");
// define('MYSQL_USER','root');
// define('MYSQL_PASSWORD','jiebao2015');
// define('MYSQL_DB','jiebao_develop');
// define('MEMCACHE_HOST','27.0.0.1');
// define('MEMCACHE_PORT',11211);
// define("API_ACCESS_CONTROL","Access-Control-Allow-Origin:http://admindev.kanjiebao.com");

/*
 * @desc		本地环境
 *
 * */

//define("API_URL","api.jiebao.com/");
//define('MYSQL_USER','root');
//define('MYSQL_PASSWORD','root');
//define('MYSQL_DB','jiebao_develop');
//define('MEMCACHE_HOST','27.0.0.1');
//define('MEMCACHE_PORT',11211);
//define("API_ACCESS_CONTROL","Access-Control-Allow-Origin:http://admindev.kanjiebao.com");








































