<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = htmlspecialchars($_POST['messages']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //sqlインジェクション処理
  $thread_name = $mysqli->real_escape_string($_GET['thread_name']);
  $result_name = $mysqli->query("select name from thread where id = '{$thread_name}'");

  // フォームで受け取ったメッセージをデータベースに登録
  if (!empty($_POST['messages_name']) && !empty($_POST['messages_comment'])&& !empty($_POST['messages_pass']) &&!empty($_POST['thread_name'])) {
    //sqlインジェクション処理
    $messages_name = $mysqli->real_escape_string($_POST['messages_name']);
    $messages_comment = $mysqli->real_escape_string($_POST['messages_comment']);
    $messages_pass = $mysqli->real_escape_string($_POST['messages_pass']);
    $thread_name = $mysqli->real_escape_string($_POST['thread_name']);
    $result= $mysqli->query("insert into messages (name,body,password,thread_id) values ('{$messages_name}','{$messages_comment}','{$messages_pass}','{$thread_name}')");
    if (!$result) {
      exit();
      # code...
    }
    $result_message = 'データベースに登録しました！XD';

  } else {
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
    //sqlインジェクション処理
    $pass = $mysqli->real_escape_string($_POST['pass']);
    $mysqli->query("delete from `messages` where `id` = {$_POST['del']} and password = '{$pass}'");
  }
}


$query= $mysqli->query("select * from thread inner join messages on thread.id = messages.thread_id`");
$result = $mysqli->query("select * from messages where thread_id = '{$_GET['thread_name']}' order by `id` desc");
$result_name = $mysqli->query("select * from `thread` where id = '{$_GET['thread_name']}'");



?>

<!--入力フォーム-->
<html>
<head>
  <meta charset="UTF-8">
</head>

<body>
  <?php foreach($result_name as $row) :?>
    <font size ="6"><?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>掲示板</font>
    <p><?php echo $result_message; ?></p>
  <?php endforeach; ?>
  <form action="" method="post">
    <div><label for="名前">    名前:<label>    <!--名前入力フォーム -->
      <input type="text" name="messages_name" />
    </div>
    <div><label for="名前">   コメント:<label>    <!--名前入力フォーム -->
      <input type="text" name="messages_comment" />
    </div>
    <div><label for="パスワード">パスワード:<label> <!--パスワード入力-->
      <input type="password" name="messages_pass" />
    </div>
    <input type="hidden" name="thread_name" value="<?php echo $_GET['thread_name']?>">
    <input type="submit" value="メッセージ追加"/>
  </form>


  <!--テーブル表示-->
  <?php foreach ($result as $row) : ?>
    <p>
      <?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>
      <?php echo htmlspecialchars($row['body'],ENT_QUOTES,'UTF-8'); ?>
      <?php echo htmlspecialchars($row['nowtime'],ENT_QUOTES,'UTF-8'); ?>
      <form action="" method="post">
        <input type="password" name="pass"/>
        <!--削除ボタン-->
        <input type="hidden" name="del" value="<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'); ?>" />
        <input type="submit" value="削除" />
      </form>
      <!--編集ボタン-->
      <form action="messages_edit.php" method="post">
        <input type="hidden" name="edit" value="<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'); ?>">
        <input type="submit" value="編集する">
      </form>
    </p>
  <?php endforeach; ?>
</body>
<a href="top.php">ホーム画面に戻る</a>
</html>
