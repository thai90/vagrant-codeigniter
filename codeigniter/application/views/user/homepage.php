<script>
$('document').ready(function(){
    var track_list = 1;
    var pageNum = <?php echo $pageNum?>;

    //ツイートの数は１０以下の場合、「もっと見る」ボタンは無効になる
    if(track_list >= pageNum){
        $('#loadMore').attr('disabled','disabled');
    }

    //最初、「投稿」ボタンが無効
    $('#post').attr('disabled','disabled');

    //ユーザが「もっと見る」ボタンをクリックすると実施するファンクション
    $('#loadMore').click(function(){
        $(this).hide();
        $.ajax({
            url : "<?php echo site_url('tweet/loadNextPage');?>",
            type: "POST",
            data : {
                page:track_list,
                <?php echo $this->security->get_csrf_token_name()?>:'<?php echo $this->security->get_csrf_hash()?>',
            },
            success: function(data, textStatus, jqXHR){
                jQuery.each(data,function(i,item){
                    $("#result").append('<div class="panel panel-info"><div class="panel-heading">'
                        +item.name+'<br/>'
                        +item.post_time+'</div><div class="panel-body">'
                        +item.tweet+'</div></div>');
                });
                $('#loadMore').show();
                $("html, body").animate({scrollTop: $("#loadMore").offset().top}, 500);
                track_list++;
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('サーバにエラーが発生したので、データロードできない');
            }
        });

        if(track_list >= pageNum){
            $('#loadMore').attr('disabled','disabled');
        }
    });

    //ユーザがツイート記入ボックスに内容をクリックすると、実施するファンクション
    $('#tweet_input').keyup(function(){
        if($('#tweet_input').val().trim() == ""){
            $('#post').attr('disabled','disabled');
            $('#post_button_area').show();
            return;
        }
        $('#post').removeAttr('disabled');
        $('#post_button_area').hide();
    });

    //ユーザが「投稿」ボタンを」クリックすると実施するファンクション
    $('#post').click(function(){
        var newTweet = $('#tweet_input').val();
        $.ajax({
            url:'<?php echo site_url("tweet/updateNewTweet");?>',
            type:'POST',
            data:{
                userID: <?php echo $userData['userID'];?>,
                newTweet:newTweet,
                <?php echo $this->security->get_csrf_token_name()?>:'<?php echo $this->security->get_csrf_hash()?>',
            },
            success:function(data,textStatus,jqXHR){
                $('#result').prepend($('<div class="panel panel-info"><div class="panel-heading">'
                   +data.username+'<br/>'
                   +data.post_time+'</div><div class="panel-body">'
                   +data.tweet+'</div></div>').fadeIn('slow'));
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log('サーバにエラーが発生したので、データロードできない');
            }
        });
        $('#tweet_input').val('');
        $('#post').attr('disabled','disabled');
        $('#post_button_area').show();
    });

    $('#post_button_area').click(function(){
            if($('#tweet_input').val() == ''){
                $('#tweet_empty_mess').fadeIn('slow');
            }
    }).mouseleave(function(){
            $('#tweet_empty_mess').fadeOut(1000);
    });
});

</script>
<link href="<?php echo base_url('application/asset/css/user_homepage.css');?>?<?php echo date('l jS \of F Y h:i:s A');?>" rel="stylesheet">
<div class="tweets_block">
  <div class="inner_div">
    <textarea id="tweet_input" class="form-control" maxlength="140"></textarea><br/>
    <div id="tweet_empty_mess"  class="alert alert-danger"><span>ツイートの内容を記入してください</span></div>
    <div style="position:relative">
      <div id="post_button_area" ></div>
      <button id="post" class="btn btn-success">投稿</button><br/><br/><hr/>
    </div>
    <div id='result'>
      <?php
      foreach($newTweets as $item){
          echo '<div class="panel panel-info"><div class="panel-heading">'.$item['name'].'<br/>'.$item['post_time'].'</div><div class="panel-body">'.$item['tweet'].'</div></div>';
      }
      ?>
    </div>
    <button id="loadMore" class="btn btn-success">もっと見る</button>
  </div>
</div>