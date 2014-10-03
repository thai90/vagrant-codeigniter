<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 </head>
 <body>
   <?php echo form_open('user/login');?>
     <h5>Emailアドレス:</h5>
     <input type="text" size="20" id="email" name="email" value="<?php echo set_value('email');?>"/>
     <?php echo form_error('email');?>
     <h5>パスワード:</h5>
     <input type="password" size="20" id="passowrd" name="password"/>
     <?php echo form_error('password');?>
     <br/>
     <input type="submit" value="ログイン"/>
   </form>
   <?php echo anchor('user/register','アカウント登録');?> 
 </body>
</html>