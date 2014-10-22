<div class='block'>
  <div class='form_block'>
    <?php echo form_open('user/register');?>
      <h4>ユーザ名</h4>
      <input type="text" name="username" value="<?php echo set_value('username')?>"/>
      <?php echo form_error('username');?>
      <h4>パスワード</h4>
      <input type="password" name="password" value="" />
      <?php echo form_error('password');?>
      <h4>パスワード確認</h4>
      <input type="password" name="passcnf" value="" />
      <?php echo form_error('passcnf');?>
      <h4>Emailアドレス</h4>
      <input type="text" name="email" value="<?php echo set_value('email')?>" />
      <?php echo form_error('email');?>
      <br/><br/>
      <button type="submit" class="btn btn-success" id="register" >登録</button>
    <?php echo form_close()."<br/>";
    echo anchor("user/login","ログイン戻る");?>
  </div>
</div>