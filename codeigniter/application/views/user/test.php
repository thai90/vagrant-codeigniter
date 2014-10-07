<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="<?php echo base_url('application/asset/js/jquery-1.11.1.min.js');?>"></script>
<script>
	$('document').ready(function(){
		$('#button').click(function(){
		
			$.post('<?php echo site_url("user/test");?>',{
				name:'michael',
				age:'25',
				<?php echo $this->security->get_csrf_token_name()?>:'<?php echo $this->security->get_csrf_hash()?>',
			},function(data,status){
				alert("Data"+data+", Status:"+status);

				});
			});
		});
</script>
<style>
	#panel,#flip,#panel2{
		padding:5px;
		text-align:center;
		background-color: yellow;
		border:solid 1px #c3c3c3;
	}
	#panel,#panel2
	{
		padding:50px;
		display:none;
	}
</style>
</head>
<body>
	<button id = "button">Click me!</button>
</body>
</html>