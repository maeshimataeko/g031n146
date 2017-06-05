<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = $mysqli->real_escape_string($_POST['thread']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // フォームで受け取ったメッセージをデータベースに登録
  if (!empty($_POST['thread_name']) && !empty($_POST['thread_pass'])) {
    //sqlインジェクション処理
    $thread_name = $mysqli->real_escape_string($_POST['thread_name']);
    $thread_pass = $mysqli->real_escape_string($_POST['thread_pass']);
    $mysqli->query("insert into thread (name,pass) values ('{$thread_name}','{$thread_pass}')");
    $result_message = 'スレッドを追加しました！XD';
  } else {
    $result_message = 'メッセージを入力してください...XO';
  }
  //削除ボタンが押された場合
  if (!empty($_POST['del'])) {
    $pass = $mysqli->real_escape_string($_POST['pass']);
    $mysqli->query("delete from `thread` where `id` = {$_POST['del']} and pass = '$pass'");
  }
  //編集ボタンが押された場合
  if (!empty($_POST['edit'])) {
    header("Location: thread_edit.php");
  }

}


// データベースからレコード取得
$result = $mysqli->query('select * from `thread` order by `id` desc');
?>

<!--入力フォーム-->
<html>
<head>
  <meta charset="UTF-8">
</head>
<body>
  <font size ="6">スレッド一覧</font>
  <form action="" method="post">
    <div><label for="名前">    名前:<label>    <!--名前入力フォーム -->
      <input type="text" name="thread_name"/>
    </div>
    <div><label for="パスワード">パスワード:<label> <!--パスワード入力-->
      <input type="password" name="thread_pass" />
    </div>
    <input type="submit" value="追加"/>
  </form>


  <!--テーブル表示-->
  <?php foreach ($result as $row) : ?>
    <p>
      <a href="messages.php?thread_name=<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'); ?>"><?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?></a>
      <?php echo $row['time']; ?>
        <form action="" method="post">
        <input type="password" name="pass"/>




        <!--削除ボタン-->
         <form action="" method="post">
          <input type="hidden" name="del" value="<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'); ?>" />
          <input type="submit" value="削除" /></form>
          <!--編集ボタン-->
          <form action="thread_edit.php" method="post">
            <input type="hidden" name="edit" value="<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'); ?>" />
            <input type="submit" value="編集する">
          </form>
     </p>
  <?php endforeach; ?>
</body>
</html>
