<!-- bbs/messages.php -->

<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);

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
    $result_message = 'メッセージを入力してください...XO';
    var_dump($_POST['thread_name']);
    var_dump($_GET['thread_name']);
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
   $mysqli->query("delete from `messages` where `id` = {$_POST['del']} and password = '{$_POST['pass']}'");
    $result_message = 'メッセージを削除しました;)';
  }

}

$query= $mysqli->query("select * from thread inner join messages on thread.id = messages.thread_id`;");
  $result = $mysqli->query('select * from messages order by thread_id desc');


// データベースからレコード取得
?>

<!--入力フォーム-->
<html>
  <head>
    <meta charset="UTF-8">
  </head>

  <body>
    <?php var_dump($_GET['thread_name']); ?>
    <p><?php echo $result_message; ?></p>
    <form action="" method="post">
       <div><label for="名前">    名前:<label>    <!--名前入力フォーム -->
         <input type="text" name="messages_name" />
       </div>
       <div><label for="名前">   コメント:<label>    <!--名前入力フォーム -->
         <input type="text" name="messages_comment" />
       </div>
       <div><label for="パスワード">パスワード:<label> <!--パスワード入力-->
         <input type="text" name="messages_pass" />
       </div>
       <input type="hidden" name="thread_name" value="<?php echo $_GET['thread_name']?>">
      <input type="submit" />
    </form>


<!--テーブル表示-->
    <?php foreach ($result as $row) : ?>
      <p>
        <form action="" method="post">
          <?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>
          <?php echo htmlspecialchars($row['body'],ENT_QUOTES,'UTF-8'); ?>
          <?php echo htmlspecialchars($row['nowtime'],ENT_QUOTES,'UTF-8'); ?>
          <form action="" method="post">
          <input type="text" name="pass"/>
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
