<?php
// データベースに接続
$db_user = 'root';     // ユーザー名
$db_pass = 'U=3dt68Wm8'; // パスワード
$db_name = 'bbs';     // データベース名
$err_msg ="";
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$message = $mysqli->real_escape_string($_POST['thread']);
//編集
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!empty($_POST['edit']) and !empty($_POST['name']) and !empty($_POST['pass']) ) {
     		$query = $mysqli->query("SELECT `thread_pass` FROM `thread` WHERE id = {$_POST['edit']}");

				foreach($query as $row){
					//パスワード認証
        if($row['thread_pass'] == $_POST['pass']){
					$result = $mysqli->query("UPDATE `thread` SET `thread_name`='{$_POST['name']}' WHERE id = '{$_POST['edit']}' ");
					header("Location: top.php");
				}
				else{
					$err_msg = "パスワード違います"; //エラーメッセージ
				}
			}
			}
}


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
<p>
<?php
echo $result; ?></p>
<p>内容を変更して下さい。</p>
<form action="" method="post">
		<!--名前フォーム-->
		<div><label for="名前">    名前:<label>
		<input type="text" name="name" />
		 </div>
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
