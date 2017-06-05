<?php
// データベースに接続
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名
$err_msg ="";
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = htmlspecialchars($_POST['messages']);

//編集
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['edit']) && !empty($_POST['name']) && !empty($_POST['pass'])) {

    //sqlインジェクション処理
    $id = $mysqli->real_escape_string($_POST['edit']);
    $query = $mysqli->query("SELECT `password` FROM `messages` WHERE id = {$id}");

    foreach($query as $row){
      //パスワード認証
      if($row['password'] == $_POST['pass']){
        //sqlインジェクション処理
        $body = $mysqli->real_escape_string($_POST['body']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $id = $mysqli->real_escape_string($_POST['edit']);
        $result = $mysqli->query("UPDATE `messages` SET `body`='{$body}',`name`='{$name}' WHERE id = '{$id}' ");
        header("Location: top.php");

      }else{
        $err_msg = "パスワード違います"; //エラーメッセージ
        
      }
    }
  }
}

$result2 = $mysqli->query("select * from `messages` where id = '{$_POST['edit']}'");

?>
<!--編集画面-->
<html>
<head>
  <title>編集画面</title>
</head>
<body>
  <h1>変更画面</h1>
  <p><?php　echo $err_msg;?></p>
  <p>内容を変更して下さい。</p>
  <?php foreach($result2 as $row) :?>
  <form action="" method="post">
      <!--名前フォーム-->
      <div><label for="名前">    名前:<label>
        <input type="text" name="name" value = "<?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>"/>
      </div>
      <!--パスワードフォーム-->
      <div><label for="メッセージ">メッセージ:<label>
        <input type="text" name="body" value = "<?php echo htmlspecialchars($row['body'],ENT_QUOTES,'UTF-8'); ?>"/>
      </div>
      <div><label for="パスワード">パスワード:<label>
        <input type="password" name="pass" />
      </div>
      <!--編集ボタン-->
      <input type="hidden" name="edit" value="<?php echo $_POST['edit']?>">
      <input type="submit" value="変更する"></br>
      <!--ページ遷移-->
  <?php endforeach; ?>
  <a href="top.php">ホーム画面に戻る</a>
  </form>
</body>
</html>
