<?php
// データベースに接続
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名
$err_msg ="";
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = $mysqli->real_escape_string($_POST['thread']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //sqlインジェクション処理
  $id = $mysqli->real_escape_string($_POST['edit']);
  //編集機能
  if (!empty($_POST['edit']) and !empty($_POST['name']) and !empty($_POST['pass']) ) {
    $query = $mysqli->query("SELECT `pass` FROM `thread` WHERE id = {$id}");

    foreach($query as $row){
      //パスワード認証
      if($row['pass'] == $_POST['pass']){
        $name = $mysqli->real_escape_string($_POST['name']);
        $result = $mysqli->query("UPDATE `thread` SET `name`='{$name}' WHERE id = '{$id}' ");
        header("Location: top.php");
      }
      else{
        $err_msg = "パスワード違います"; //エラーメッセージ
      }
    }
  }
}

$result = $mysqli->query("SELECT * FROM `thread` WHERE id = {$_POST['edit']}");

?>
<!--編集画面-->
<html>
<head>
  <title>編集画面</title>
</head>
<body>
  <h1>変更画面</h1>
  <p><?php
  echo $err_msg;?>
</p>
<p>内容を変更して下さい。</p>
<form action="" method="post">

  <!--名前フォーム-->
  <?php foreach($result as $row) :?>
    <div><label for="名前">名前:<label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?>"/>
    </div>
  <?php endforeach; ?>
  <!--パスワードフォーム-->
  <div><label for="パスワード">パスワード:<label>
    <input type="password" name="pass" />
  </div>

  <!--編集ボタン-->
  <input type="hidden" name="edit" value="<?php echo $_POST['edit']?>">
  <input type="submit" value="変更する"></br>

  <!--ページ遷移-->
  <a href="top.php">ホーム画面に戻る</a>
</form>
</body>
</html>
