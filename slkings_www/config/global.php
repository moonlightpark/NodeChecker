<?php
header("Content-type: text/html; charset=UTF-8");

date_default_timezone_set('Asia/Seoul');

define("__ENV_DOCUMENT_ROOT__", $_SERVER['DOCUMENT_ROOT'] );     //The document root directory.
define("__ENV_HTTP_HOST__", $_SERVER['HTTP_HOST']);              // Contents of the Host : ex) www.sample.com
define("__ENV_REMOTE_IP__", getenv('HTTP_X_FORWARDED_FOR'));     // user  IP-address
define("__ENV_SERVER_IP__",$_SERVER['SERVER_ADDR']);             // server IP-address
define("__ENV_HTTP_USER_AGENT__", $_SERVER['HTTP_USER_AGENT'] ); //  Environment of connected user
define('__ENV_REQUEST_URI__', $_SERVER['REQUEST_URI'] );         // URL
define("__ENV_SERVER_OS__", strtoupper(getenv("OS")) );          // Server's operating system
define("__ENV_STATIC_VER__", "1.0.0.".time());                   // version ( javascript, css )
define('__ENV_SHA__', 'sha512');                                 //128 characters
define('__ENV_MD5__', 'md5');  		                             //32  characters
define('__ENV_TODAY__', date("Y-m-d") );                         // 2023-10-07
define('__ENV_NOW_TIME__',date("H:i:s") );                       // 21:22:33
