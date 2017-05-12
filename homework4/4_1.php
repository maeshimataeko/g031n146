<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['message'])) {
    $mysqli->query("insert into `messages` (`body`,`name`) values ('{$_POST['message']}','{$_POST['myname']}')");
    $result_message = 'データベースに登録しました！XD';
    echo $result_message;
  } else {
    $result_message = 'メッセージを入力してください...XO';
    echo $result_message;
  }
  $result = mysql_query('SELECT * FROM messages');
}


$sql = "SELECT * FROM messages ORDER BY id DESC";

$result = $mysqli -> query($sql);

if(!$result) {
	echo $mysqli->error;
	exit();
}

$row_count = $result->num_rows;

while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$rows[] = $row;
}

$result->free();

?>

<html>
  <head>
    <title>nameテーブル表示</title>
    <meta charset="UTF-8">
  </head>

  <body>
    <h1>messagesテーブル表示</h1></br>

レコード件数：<?php echo $row_count; ?></br>



<?php
foreach($rows as $row){
?>
<tr>
  <p><?php echo htmlspecialchars($row['body'],ENT_QUOTES,'UTF-8'); ?></p>
	<p>name:<?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'); ?></p>
  <p>time:<?php echo htmlspecialchars($row['nowtime'],ENT_QUOTES,'UTF-8'); ?></p></br>
</tr>
<?php
}
?>

    <form action="" method="post">
      <p>メッセージを入力してね</p></br>
      <input type="text" name="message" />
      <p>あなたのニックネームをおしえてね</p></br>
      <input type="text" name="myname" />
      <input type="submit" />
    </form>
  </body>
</html>
