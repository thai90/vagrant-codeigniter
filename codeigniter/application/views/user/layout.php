<!Doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo base_url('application/asset/js/jquery-1.11.1.min.js');?>"></script>
  <script src="<?php echo base_url('application/asset/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('application/asset/js/myFunction.js');?>"></script>
  <link href="<?php echo base_url('application/asset/css/bootstrap.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('application/asset/css/tweet.css');?>?<?php echo date('l jS \of F Y h:i:s A');?>" rel="stylesheet">
  <title>Sample page</title>
</head>
<body background="<?php echo base_url('application/asset/image/background3.jpeg');?>">
  <div class='div_menu'>
    <div style="float:right">
      <?php
      $this->load->library('session');
      $userData = $this->session->userdata('logged_in');
      echo $userData['username'].'様<br/>';
      echo '<div id = "logout">'.anchor('user/logout','ログアウト').'</div>';
      ?>
    </div>
    <div>
      <b style="font-size:20px">ツイーター</b><br/>
      <span>ここから人々にコネクト</span>
    </div>
  </div>
  <div> <?php echo $content?></div>
  <div></div>
</body>
</html>