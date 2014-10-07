<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="<?php echo base_url('application/asset/js/jquery-1.11.1.min.js');?>"></script>
	<script>
	$('document').ready(function(){
		var track_list =1;
		var pageNum = <?php echo $pageNum?>;
		if(track_list >= pageNum)
			$('#loadMore').attr('disabled','disabled');
		$('#loadMore').click(function(){
			$(this).hide();
			$.ajax({
				url : "<?php echo site_url('user/homepage'); ?>",
				type: "POST",
				data : {
					page:track_list,
					<?php echo $this->security->get_csrf_token_name()?>:'<?php echo $this->security->get_csrf_hash()?>',
				},
				success: function(data, textStatus, jqXHR)
				{
					$('#result').append(data);
					$('#loadMore').show();
					$("html, body").animate({scrollTop: $("#loadMore").offset().top}, 500);                 
					track_list++;
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('サーバにエラーが発生したので、データロードできない');
				}
			});

			if(track_list >= pageNum)
				$('#loadMore').attr('disabled','disabled');
		});
	});

	</script>
	<body>
		<?php 
		echo $userData['username'].'<br/>';
		echo anchor('user/logout','ログアウト');
		?>
		<div id = 'result'>
			<?php print_r($newTweets);?>
		</div>
		<button id="loadMore">もっと見る</button>
	</body>
</head>
</html>