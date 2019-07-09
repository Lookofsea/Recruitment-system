<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_company_id=is_login_company($link);
if(!$member_company_id){
	skip('index_company.php','error','你没有登录，不需要退出！');
}
setcookie('sfk[name]','',time()-3600);
setcookie('sfk[pw]','',time()-3600);
skip('index_company.php','ok','退出成功！');
?>