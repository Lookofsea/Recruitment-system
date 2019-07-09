<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$is_manage_login=is_manage_login($link);
$member_company_id=is_login_company($link);
if(!$member_company_id && !$is_manage_login){
	skip('login.php', 'error', '您没有登录!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index_company.php', 'error', '帖子id参数不合法!');
}
$query="select member_id from sfk_content where id={$_GET['id']}"; //招聘用户
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	if(check_user($member_company_id,$data_content['member_id'],$is_manage_login)){
		$query="delete from sfk_content where id={$_GET['id']}";
		execute($link, $query);
		if(isset($_GET['return_url'])){
			$return_url=$_GET['return_url'];
		}else{
			$return_url="member_company.php?id={$member_company_id}";
		}
		if(mysqli_affected_rows($link)==1){
			skip($return_url, 'ok', '恭喜你，删除成功!');
		}else{
			skip($return_url, 'error', '对不起删除失败!');
		}
	}else{
		skip('index_company.php', 'error', '这个帖子不属于你，你没有权限!');
	}
}else{
	skip('index_company.php', 'error', '帖子不存在!');
}
?>