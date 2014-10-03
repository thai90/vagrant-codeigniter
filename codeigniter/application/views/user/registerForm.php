<html>
<head>
<title>登録</title>
</head>
<body>


<?php echo form_open('user/register'); ?>
<h5>ユーザ名</h5>
<input type="text" name="username" value="<?php echo set_value('username')?>" size="50" />
<?php echo form_error('username');?>

<h5>パスワード</h5>
<input type="password" name="password" value="" size="50" />
<?php echo form_error('password');?>

<h5>パスワード確認</h5>
<input type="password" name="passcnf" value="" size="50" />
<?php echo form_error('passcnf');?>

<h5>Emailアドレス</h5>
<input type="text" name="email" value="<?php echo set_value('email')?>" size="50" />
<?php echo form_error('email');?>

<div><input type="submit" value="サブミット" /></div>

</form>

</body>
</html>