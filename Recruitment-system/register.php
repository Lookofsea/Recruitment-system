<?php 
define('IN_SFKBBS',true);
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
$member_company_id = is_login($link);
if($member_id){
	skip('index.php','error','你已经登录，请不要重复注册！');
}
if(isset($_POST['submit'])){
	include 'inc/check_register.inc.php';
	if($_POST['individual'] == 1) {
		$query="insert into sfk_member(name,pw,register_time,photo,last_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now(),'',now())";
	}
	
	else {
		$query = "insert into member_company(name,pw,register_time,photo,last_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now(),'',now())";
	}
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('sfk[name]',$_POST['name']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])));
		if($_POST['individual'] == 1) {
			skip('index.php','ok','注册成功！');
		}
		else {
			skip('index_company.php','ok','注册成功!');
		}
	}else{
		skip('register.php','eror','注册失败,请重试！');
	}
}

$template['title']='会员注册页';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include 'inc/header.inc.php'?>
	<div id = "register" class = "auto" >
		<h2>欢迎注册</h2>
		<form method="post">
			
			<label>用户名：<input class = "myinput" type="text" name="name"  /><span>*用户名不得为空，并且长度不得超过32个字符</span></label>
			<label>密码：<input class = "myinput" type="password" name="pw"  /><span>*密码不得少于6位</span></label>
			
			<label>确认密码：<input class = "myinput" type="password" name="confirm_pw"  /><span>*请输入与上面一致</span></label>
			
			<label>身份：<input type="radio" checked="checked" name="individual" value = 1 />求职人员
		   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   	<input  type="radio"  name="individual" value = 2/>招聘人员<span>*必须选择职位</span></label>
		   	<label>验证码：<input class = "myinput" name="vcode" name="vocode" type="text"  /><span>*请输入下方验证码</span></label>
					<img class="vcode" src="show_code.php" />
			<div style="clear:both;"></div>  <!--清除同行元素 -->
			<input class="btn" name="submit" type="submit" value="确定注册" />
		</form>
	
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>zpxt</a>
		</div>
		<div class="copyright">Powered by </div>
	</div>
</body>
</html>