<!-- bbs/messages.php -->

<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = htmlspecialchars($_POST['messages']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // フォームで受け取ったメッセージをデータベースに登録
  if (!empty($_POST['messages_name']) && !empty($_POST['messages_comment'])&& !empty($_POST['messages_pass']) &&!empty($_POST['thread_name'])) {
    $result= $mysqli->query("insert into messages (name,body,password,thread_id) values ('{$_POST['messages_name']}','{$_POST['messages_comment']}','{$_POST['messages_pass']}','{$_POST['thread_name']}')");
if (!$result) {
  exit();
  # code...
}
    $result_message = 'データベースに登録しました！XD';

  } else {
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
   $mysqli->query("delete from `messages` where `id` = {$_POST['del']} and password = '{$_POST['pass']}'");
  }
}


 $query= $mysqli->query("select * from thread inner join messages on thread.id = messages.thread_id`");
//echo "select * from messages where thread_id = '{$_POST['thread_name']}' order by `id` desc";

  $result = $mysqli->query("select * from messages where thread_id = '{$_GET['thread_name']}' order by `id` desc");
  $result_name = $mysqli->query("select thread_name from thread where id = '{$_GET['thread_name']}'");


// データベースからレコード取得
?>

<!--入力フォーム-->
<html>
  <head>
    <meta charset="UTF-8">
  </head>

  <body>
    <font size ="6">掲示板</font>
    <p><?php echo $result_message; ?></p>
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
          <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
          <input type="submit" value="削除" />
        </form>
        <!--編集ボタン-->
       <form action="messages_edit.php" method="post">
         <input type="hidden" name="edit" value="<?php echo $row['id']; ?>">
         <input type="submit" value="編集する">
       </form>
      </p>
    <?php endforeach; ?>
  </body>
</html>
