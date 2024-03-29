<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();

if(isset($_POST['submit'])){
	if($_POST['individual'] == 1) {
		$member_id=is_login($link);
		if($member_id){
			skip('index.php','error','你已经登录，请不要重复登录！');
		}
	include 'inc/check_login.inc.php';
	escape($link,$_POST);
	$query="select * from sfk_member where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
	$result=execute($link, $query);
	if(mysqli_num_rows($result)==1){
		setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])),time()+$_POST['time']);
		/*设置这个登录的会员对于的last_time这个字段为now()*/
		skip('index.php','ok','登录成功！');
	}else{
		skip('login.php', 'error', '用户名或密码填写错误！');
	}
	}
	else {
		$member_company_id=is_login_company($link);
		if($member_company_id){
			skip('index_company.php','error','你已经登录，请不要重复登录！');
		}
		$member_company_id = is_login($link);
		escape($link,$_POST);
		$query="select * from member_company where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
		$result=execute($link, $query);
		if(mysqli_num_rows($result)==1){
			setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
			setcookie('sfk[pw]',sha1(md5($_POST['pw'])),time()+$_POST['time']);
			/*设置这个登录的会员对于的last_time这个字段为now()*/
			skip('index_company.php','ok','登录成功！');
		}else{
			skip('login.php', 'error', '用户名或密码填写错误！');
		}
	}
}
$template['title']='欢迎登录';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include 'inc/header.inc.php'?>
	<div id="register" class="auto">
		<h2>请登录</h2>
		<form method="post">
			<label>用户名：<input class = "myinput" type="text" name="name"  /><span></span></label>
			<label>密码：<input class = "myinput" type="password" name="pw"  /><span></span></label>
			<label>身份：<input type="radio" checked="checked" name="individual" value = 1 />求职人员
		   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   	<input  type="radio"  name="individual" value = 2/>招聘人员<span>*必须选择职位</span></label>
			<label>验证码：<input class = "myinput" name="vcode" type="text"  /><span>*输入下方验证码</span></label>
			<img class="vcode" src="show_code.php" />
			<label>自动登录：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">1小时内</option>
					<option value="86400">1天内</option>
					<option value="259200">3天内</option>
					<option value="2592000">30天内</option>
				</select>
				<span>*公共电脑上请勿长期自动登录</span>
			</label>
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="登录" />
		</form>
	</div>
<?php include 'inc/footer.inc.php'?>