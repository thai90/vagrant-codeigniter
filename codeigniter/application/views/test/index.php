<!DOCTYPE html>
<!-- テストの結果　-->
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
  <h1>TEST</h1>
  <h2>新規登録に関するテスト</h2>
  <?php
    echo $insert[0];
  ?>

  <h2>ごログインに関するテスト</h2>
  <h3>ログインの期待結果が成功</h3>
  <?php
      echo $check_login[0];
  ?>
  <h3>ログインの期待結果が失敗</h3>
  <?php
      echo $check_login[1];
  ?>

  <h2>get_newTweetsテスト</h2>
  <?php
      echo $get_newTweets[0];
  ?>

  <h2>get_TweetNumsテスト</h2>
  <?php
      echo $get_TweetNums[0];
  ?>

  <h2>updateNewTweetテスト</h2>
  <?php
      echo $updateNewTweet[0];
  ?>

  <h2>deleteTweetテスト</h2>
  <?php
      echo $deleteTweet[0];
  ?>

  <h2>isTweetInCacheテスト</h2>
  <?php
      echo $isTweetInCache[0];
  ?>
</body>
</html>