<script>
$('document').ready(function(){
    var track_list =1;
    var pageNum = <?php echo $pageNum?>;

    //ツイートの数は１０以下の場合、「もっと見る」ボタンは無効になる
    if(track_list >= pageNum)
       $('#loadMore').attr('disabled','disabled');

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
            success: function(data, textStatus, jqXHR)
            {
                responseObj = jQuery.parseJSON(data);
                jQuery.each(responseObj,function(i,item){
                    $("#result").append('<div class="panel panel-info"><div class="panel-heading">'
                        +item.name+'<br/>'
                        +item.post_time+'</div><div class = "panel-body">'
                        +item.tweet+'</div></div>');
                });
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

    //ユーザがツイート記入ボックスに内容をクリックすると、実施するファンクション
    $('#tweet_input').keyup(function(){
        if($('#tweet_input').val().trim() == "") $('#post').attr('disabled','disabled');
        else $('#post').removeAttr('disabled');
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

                newTweetInfo = jQuery.parseJSON(data);

                $('#result').prepend($('<div class="panel panel-info"><div class="panel-heading">'
                   +newTweetInfo.username+'<br/>'
                   +newTweetInfo.post_time+'</div><div class = "panel-body">'
                   +newTweetInfo.tweet+'</div></div>').fadeIn('slow'));
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('サーバにエラーが発生したので、データロードできない');
            }
        }
        );
        $('#tweet_input').val('');
        $('#post').attr('disabled','disabled');
    });

$('#post_button_area').click(function(){
    if($('#tweet_input').val() == '')
        $('#tweet_empty_mess').fadeIn('slow');
}).mouseleave(function(){
    $('#tweet_empty_mess').fadeOut(1000);
});

    /*$('#post_button_area').mouseleave(function(){
        if($('#tweet_input').val() == '')
            $('#tweet_empty_mess').fadeOut('slow');
    });*/
});

</script>
<div class = "tweets_block">
    <div class = "inner_div">
        <textarea id = "tweet_input" class = "form-control" rows = "3" style = "resize:none" maxlength = "140"></textarea><br/>
        <div id = "tweet_empty_mess"  class= "alert alert-danger" style = "display:none;float:right"><span>ツイートの内容を記入してください</span></div>
        <div style = "position:relative">
            <div id = "post_button_area" style = "position:absolute;top:0;left:0;height:40px;width:22%"></div>
            <button id ="post" class = "btn btn-success" style = "width:20%">投稿</button><br/><br/><hr/>
        </div>
        <div id='result'>
          <?php
          foreach($newTweets as $item)
          {
              echo '<div class = "panel panel-info"><div class = "panel-heading">'
              .$item['name'].'<br/>'
              .$item['post_time'].'</div><div class = "panel-body">'
              .$item['tweet'].'</div></div>';
          }
          ?>
      </div>
      <button id = "loadMore" class = "btn btn-success" style = "width:20%">もっと見る</button>
  </div>
</div>