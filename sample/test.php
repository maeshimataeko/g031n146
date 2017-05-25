<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // フォームで受け取ったメッセージをデータベースに登録
  if (!empty($_POST['message'])) {
    $mysqli->query("insert into `messages` (`body`,`name`,`password`) values ('{$_POST['message']}','{$_POST['name']}','{$_POST['pass']}')");
    $result_message = 'データベースに登録しました！XD';
  } else {
    $result_message = 'メッセージを入力してください...XO';
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
    $mysqli->query("delete from `messages` where `id` = {$_POST['del']}");
    $result_message = 'メッセージを削除しました;)';
  }
}


// データベースからレコード取得
$result = $mysqli->query('select * from `messages` order by `id` desc');
?>

<html>
  <head>
    <meta charset="UTF-8">
  </head>

  <body>
    <p><?php echo $result_message; ?></p>
    <form action="" method="post">
      <input type="text" name="message" />
      <input type="text" name="name" />
      <input type="text" name="pass" />
      <input type="submit" />
    </form>
    <form method="POST" action="<?php echo($_SERVER['PHP_SELF']) ?>">
    <?php
    if (isset($simEdit[1]) && isset($simEdit[2])) {
         echo '<input type="hidden" name="edit"><br>';
     } else {
        echo '<label for="edit">編集対象番号</label><br>
              <input type="text" name="edit"><br>
              <input type="submit" value="編集する">';
     }
    ?>
</form>

    <?php foreach ($result as $row) : ?>
      <p>
        <form action="" method="post">
          <?php echo $row['body']; ?>
          <?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>
          <?php echo htmlspecialchars($row['nowtime'],ENT_QUOTES,'UTF-8'); ?>
          <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
          <input type="submit" value="削除" />
        </form>
        <br>
      </p>
    <?php endforeach; ?>
  </body>
</html>
