<?
session_start();
error_reporting(0); 
include 'noc.php';

if ($_POST) {
	$log_v = trim($_POST['log_v']);
	$email = trim($_POST['log']);
	$password = trim($_POST['pas']);
	$password_r = trim($_POST['pas_r']);
	$name = trim($_POST['na']);
	$phone = trim($_POST['ph']);
	$surname = trim($_POST['surna']);
		
	$error = false;

	if (empty($password)) {
		$error = true;
		$errortext_pas = "<font color='red'>������������ ����</font>";
	} else {
		if (!preg_match("/^[a-zA-Z0-9]{6,}+$/",$password)) {
			$error = true;
			$errortext_pas = "<font color='red'>����������� ��������� ���� ������</font>";
		}
	}

	if (empty($email)) {
		$error = true;
		$errortext_log = "<font color='red'>������������ ����</font>";
	} else {
		if (!preg_match("/^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,4}$/i",$email))	{
			$error = true;
			$errortext_email = "<font color='red'>����������� ��������� ���� e-mail </font>";
		}
	}
		
	if (empty($password_r))	{
		$error = true;
		$errortext_pas_r= "<font color='red'>������������ ����</font>";
	} else {
		if ($password != $password_r) {
			$error = true;
			$errortext_pas_r= "<font color='red'>������ � ��� ������������� �� ���������!</font>";
		}
	}
	
	if (!preg_match("#^[-+0-9()\s]+$#",$phone))	{
		$error = true;
		$errortext_phone = "<font color='red'>����������� ��������� ���� ������� </font>";
	}
		
	$password = md5($password);
	$password_r = md5($password_r);

	if ($error == false) {
		$result = mysql_query("SELECT COUNT(*) AS Z FROM users WHERE id_us = '$log_v'",$link_id);
		$myrow = mysql_fetch_array($result);
		if ($myrow["Z"] != 0) {
			$errortext_log = "<font color='red'>����� ��� ���������������</font>";
		} else {
			$qs = mysql_query("INSERT INTO users (id_us,us_na,us_sn, us_sk, us_ml, us_ph) Values ('$log_v','$name','$surname','$password','$email','$phone')", $link_id);
			$_SESSION['us'] = $email;
			$_SESSION['sk'] = $password;
			$_SESSION['na'] = $name;
			$_SESSION['ph'] = $phone;
			$_SESSION['sn'] = $surname;
			$_SESSION['lg'] = $log_v;
			exit("<meta http-equiv='Refresh' content='0; URL=index.php'>");
		}
	}
}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>��� ����</TITLE>
        <META charset="utf-8">
		<LINK rel="stylesheet" href="style_index.css" />
	</HEAD>
	<BODY>
	<a id="join_form"></a>
	<div class="modal_window_reg">
	<a href="index.php" class="cont_v">��������� �� ������� ��������</a>
		<h2 class="block_txt"><center>�����������</center></h2>
		<form method="post">
			<label for="log_v" class="form_login_form">�����</label><br>
			<input type="text" name="log_v" maxlength="40" value="<?=@$log_v;?>" id="log_v" placeholder="�� ����� 40 ��������" autofocus/>
			<div>&nbsp;<?echo $errortext_log;?></div>		
			
			<label for="password" class="form_login_form">������</label><br>
			<input type="password" name="pas" maxlength="32" value="" id="pas" placeholder="�� ����� 6 ��������"/> 
			<div>&nbsp;<?echo $errortext_pas;?></div>				
			
			<label for="password_repeat" class="form_login_form">������������� ������</label><br>
			<input type="password" name="pas_r" maxlength="32" value="" id="pas_r" placeholder="������� ��� ������"/>
			<div>&nbsp;<?echo $errortext_pas_r;?></div>
			
			<label for="email" class="form_login_form">E-mail</label><br>
			<input type="text" name="log" maxlength="40" value="<?=@$email;?>" id="log" placeholder="user@example.ru"/>
			<div>&nbsp;<?echo $errortext_email;?></div>	
			
			<label for="phone" class="form_login_form">�������</label><br>
			<input type="text" name="ph" maxlength="40" value="<?=@$phone;?>" id="ph" placeholder="������� ���������� �������"/>
			<div>&nbsp;<?echo $errortext_phone;?></div>						
						
			<label for="name" class="form_login_form">���</label><br>
			<input type="text" name="na" maxlength="32" value="<?=@$name;?>" id="na" placeholder="�������"/>
			<div>&nbsp;</div>
			
			<label for="surname" class="form_login_form">�������</label><br>
			<input type="text" name="surna" maxlength="32" value="<?=@$surname;?>" id="surna" placeholder="������"/>
			<div>&nbsp;</div>
			<input type="submit" id="sub" value="������������������" class="log_join"/>&nbsp;&nbsp;&nbsp;���&nbsp;&nbsp;&nbsp;<a href="index.php"  class="reg_v">�����</a>
		</form>
	</div>

    </BODY>
</HTML>

