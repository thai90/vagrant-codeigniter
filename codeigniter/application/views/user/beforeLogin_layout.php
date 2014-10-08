<!Doctype html>
<html>
<head>
	<script type="text/javascript" src="<?php echo base_url('application/asset/js/jquery-1.11.1.min.js');?>"></script>
	<script src="<?php echo base_url('application/asset/js/bootstrap.min.js');?>"></script>
	<link href="<?php echo base_url('application/asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<title>Sample page</title>
	<style>
		.block {
			width:450px;
			height: 400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:120px;
		}
		.form_block{
			width:450px;
			height:300px;
			background-color: white;
			padding:20px;
			border-radius: 10px;
		}
	</style>
<head>
	<body background="<?php echo base_url('application/asset/image/background.png');?>" >
		<div> </div>
		<div> <?php echo $content?></div>
		<div> </div>

	</body>
</html>