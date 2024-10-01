<?php
define('app_name', 'dash');
define('path', 'dash');
if(session_name() != constant('app_name'))
	{
	session_name(constant('app_name'));
	session_start();
	}

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) 
	$uri = 'https://';
else
	$uri = 'http://';
$uri = $uri.$_SERVER['HTTP_HOST'].'/';

define('svr_root' , $uri.constant('path'));
define('svr_ui'   , $uri.constant('path').'/ui');
define('svr_intf' , $uri.constant('path').'/intf');
define('svr_lib'  , $uri.constant('path').'/libs');
define('svr_conn' , $uri.constant('path').'/conn');

$doc = $_SERVER['DOCUMENT_ROOT'].'/';

define('doc_root' , $doc.constant('path'));
define('doc_ui'   , $doc.'/'.constant('path').'/ui');
define('doc_intf' , $doc.'/'.constant('path').'/intf');
define('doc_lib'  , $doc.'/'.constant('path').'/libs');
define('doc_conn' , $doc.'/'.constant('path').'/conn');

define('app_title' , 'Best Parking');
define('app_copyright' , 'Copyright &copy 2023');
define('app_company' , 'PT. Bersama Solusindo Teknologi');
define('db_svr' , 'localhost');
define('db_usr' , 'u478814733_dash_2');
define('db_pwd' , 'BestParking123!');
define('db_name' , 'u478814733_dash_2');

include constant("doc_lib").'/stdlib.php';
?>