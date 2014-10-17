<div class="block">
    <div class="form_block">
        <?php echo form_open('user/login');?>
        <div class="form-group">
            <label>Emailアドレス:</label><br/>
            <input type="text" id="email" name="email" size="50" value="<?php echo set_value('email');?>" placeholder="Emailアドレスを入力してください"/>
        </div>
        <?php
        echo form_error('email');
        if(isset($email_wrong_mess)) echo '<p style = "color:red">'.$email_wrong_mess.'</p>';
        ?>
        <div class="form-group">
            <label>パスワード:</label><br/>
            <input type="password" id="passowrd" name="password" size="50"/>
        </div>
        <?php
        echo form_error('password');
        if(isset($password_wrong_mess)) echo '<p style = "color:red">'.$password_wrong_mess.'</p>';
        ?>
        <br/>
        <button type="submit" class="btn btn-success">ログイン</button>
    </form>
</div>
<div style="text-align:center">
    <?php echo form_open('user/register');?>
    <input type="submit" class="btn btn-success"
    style="margin-left:auto;margin-right:auto;margin-top:30px;width: 230px;height:60px;font-size:20px" value="登録"/>
</form>
</div>
</div>

