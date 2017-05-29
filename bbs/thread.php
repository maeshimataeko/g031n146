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

<!--入力フォーム-->
<html>
  <head>
    <meta charset="UTF-8">
  </head>

  <body>
    <p><?php echo $result_message; ?></p>
    <form action="" method="post">
       <div><label for="メッセージ">メッセージ:<label>  <!--メッセージフォーム-->
         <input type="text" name="message"/>
       </div>
       <div><label for="名前">    名前:<label>    <!--名前入力フォーム -->
         <input type="text" name="name" />
       </div>
       <div><label for="パスワード">パスワード:<label> <!--パスワード入力-->
         <input type="text" name="pass" />
       </div>
      <input type="submit" />
    </form>


<!--テーブル表示-->
    <?php foreach ($result as $row) : ?>
      <p>
        <form action="" method="post">
          <?php echo $row['body']; ?>
          <?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>
          <?php echo htmlspecialchars($row['nowtime'],ENT_QUOTES,'UTF-8'); ?>
          <!--削除ボタン-->
          <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
          <input type="submit" value="削除" />
        </form>
        <!--編集ボタン-->
       <form action="5_2.php" method="post">
         <input type="hidden" name="edit" value="<?php echo $row['id']; ?>">
         <input type="submit" value="編集する">
       </form>
      </p>
    <?php endforeach; ?>
  </body>
</html>
