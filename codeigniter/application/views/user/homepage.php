<!DOCTYPE html>
<html>
<head>
	
	<script>
	$('document').ready(function(){
		var track_list =1;
		var pageNum = <?php echo $pageNum?>;
		if(track_list >= pageNum)
			$('#loadMore').attr('disabled','disabled');
		$('#post').attr('disabled','disabled');

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


		$('#tweet_input').keyup(function(){
			if($('#tweet_input').val().trim() == "") $('#post').attr('disabled','disabled');
			else $('#post').removeAttr('disabled');
		});

		$('#post').click(function(){
			var newTweet = $('#tweet_input').val();
			$.ajax({
				url:'<?php echo site_url("user/updateNewTweet");?>',
				type:'POST',
				data:{
					userID: <?php echo $userData['userID'];?>,
					newTweet:newTweet,
					<?php echo $this->security->get_csrf_token_name()?>:'<?php echo $this->security->get_csrf_hash()?>',	
				},
				success:function(){

					$('#result').prepend('<li>'+newTweet+'</li>');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('サーバにエラーが発生したので、データロードできない');
				}

			}
			);
			$('#tweet_input').val('');
			$('#post').attr('disabled','disabled');

		});
	});

</script>
<body>
	<?php 
	echo $userData['username'].'<br/>';
	echo anchor('user/logout','ログアウト');
	?>
	<div>
		<input id="tweet_input" type="text" maxlength = '140'/>
		<button id="post">投稿</button>
	</div>
	<ul id = 'result'>
		<?php 
			foreach($newTweets as $item)
					{
						echo '<li>'.$item['name'].'<br/>'.$item['post_time'].'<br/>'.$item['tweet'].'<br/><br/>';
					}
		?>
	</ul>
	<button id="loadMore">もっと見る</button>
</body>
</head>
</html>