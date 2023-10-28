<?php

ini_set("session.cache_expire", 1440);     // 세션 만료시간을 한시간으로 설정 (모든페이지)
ini_set("session.gc_maxlifetime", 1440);   // 움직임이 없을 경우 한시간으로 설정(모든페이지)

session_set_cookie_params(3600,"/");

define("__ENV_INCLUDE_URL__", "/style/node/");// include_url css,js,vandor
define("__ENV_URL__", "/");
define("__ENV_HOME_URL__", "/");
define("__ENV_LOG_PFIX__", "web" );


define("__ENV_SHOP_INCLUDE_URL__", "/style/shop/");

// Encryption Settings
define('__ENV_HASH_PWD_KEY__', '암호키를설정하세요');   // 어려운 문자 아무거나 입력
define('__ENV_HASH_TOKEN_KEY__', '암호키를설정하세요'); // 어려운 문자 아무거나 입력
define('__ENV_CRYPT_IV__', '암호키를설정하세요');       // 어려운 문자 아무거나 입력
define('__ENV_CRYPT_KEY__', '암호키를설정하세요');      // 어려운 문자 아무거나 입력
define('__ENV_AUTH_TYPE__', 'session');

define('__ENV_RESPONSE_HEADER_LENGTH__',300);
define('__ENV_DEFALUT_REGION__',"ko" );
define('__ENV_SESSION_MAX_MINUTES__',1 );

define('__ENV_ADMIN_TITLE__',"Saseul Node Log" );
define('__ENV_ADMIN_EMAIL__', 'park@passme.kr');
define('__ENV_CHK_HTTPS__', isset($_SERVER['HTTPS'])? $_SERVER['HTTPS']: "off"); // https on

if( __ENV_CHK_HTTPS__ == "on"  ){
    define("__ENV_IMAGE_HTTPS_URL__",true);
}else{
    define("__ENV_IMAGE_HTTPS_URL__",false);
}

if(__ENV_IMAGE_HTTPS_URL__){
    define("__ENV_IMAGE_PROTOCOL__","https://");
}else{
    define("__ENV_IMAGE_PROTOCOL__","http://");
}

define("__MAX_COL__", 20);
define("__MAX_ROW__", 11);

error_reporting(E_ALL);

ini_set("display_errors",1); //Do not print to browser -> 0, output to browser -> 1

define("__ENV_HIDDEN_VALUE__", "none");
define("__ENV_SITE_TITLE__","Admin");
define("__ENV_ERROR_LEVEL__",5);
define("__HEADER_TAIL__","Saseul Node Log");
define("__ENV_DEVELOP__",0);
define('__ENV_LOG_DIR__',"/data/www/logs");


// DB Setting
define('__ENV_DB_TYPE__', 'mysql');
define('__ENV_DB_HOST__', '127.0.0.1');
define('__ENV_DB_NAME__', 'db_name');
define('__ENV_DB_USER__', 'db_user'); 
define('__ENV_DB_PASS__', 'db_pass');
define('__ENV_DB_PORT__', '3306');
