<div class='block'>
	<div class ='form_block'>
		<?php echo form_open('user/register'); ?>
		<h4>ユーザ名</h4>
		<input type="text" name="username" value="<?php echo set_value('username')?>" size="50" />
		<?php echo form_error('username');?>

		<h4>パスワード</h4>
		<input type="password" name="password" value="" size="50" />
		<?php echo form_error('password');?>

		<h4>パスワード確認</h4>
		<input type="password" name="passcnf" value="" size="50" />
		<?php echo form_error('passcnf');?>

		<h4>Emailアドレス</h4>
		<input type="text" name="email" value="<?php echo set_value('email')?>" size="50" />
		<?php echo form_error('email');?>
		<br/><br/>
		<input type="submit" class="btn btn-success" style="width:70px" xvalue="登録"/>

		<?php echo form_close()."<br/>";
		echo anchor("user/login","ログイン戻る");?>
	</div>
</div>