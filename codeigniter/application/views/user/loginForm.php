
    <div class="block">
        <div class="form_block">
    <?php if(isset($login_failed_mess)) echo '<p style="color:red">'.$login_failed_mess.'</p>';?>
   <?php echo form_open('user/login');?>
    <div class="form-group">
     <label>Emailアドレス:</label><br/>
     <input type="text" id="email" name="email" size="50" value="<?php echo set_value('email');?>" placeholder="Emailアドレスを入力してください"/>
   </div>
     <?php echo form_error('email');?>
     <div class="form-group">
     <label>パスワード:</label><br/>
     <input type="password" id="passowrd" name="password" size="50"/>
   </div>
     <?php echo form_error('password');?>
     <br/>
     <button type="submit" class="btn btn-default">サブミット</button>
   </form>
 </div>
 <div style="text-align:center">
   <?php echo '<button type="button" class="btn btn-warning" 
   style="margin-left:auto;margin-right:auto;margin-top:30px;width: 230px;height:60px;font-size:20px"><b>'
   .anchor('user/register','アカウント登録').'</b></button>';?> 
 </div>
 </div>

 