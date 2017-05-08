<?php
// パスワードにhogehogeと入力されたらユーザー名を出力する
if (($_GET["answer"] !== NULL) and $_GET["answer"] === "すえよししゅうた" or $_GET["answer"] === "末吉秀太") {

  echo "正解!!!";
}else if(($_GET['answer'] !== NULL) and $_GET['answer'] === 'sueyoshisyuta'){
  echo "正解!!!";
}else  {
  echo "不正解";
}
?>
