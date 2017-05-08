<html>
  <head>
    <meta charset="utf-8">
  </head>
       <body>
         <form action="3_4.php" method="POST">
          <p>好きなAAAのメンバーを選択してください（複数回答可）;
         <input type="checkbox" name="aaa[]" value="にっしー">にっしー
        <input type="checkbox" name="aaa[]" value="リーダー">リーダー
        <input type="checkbox" name="aaa[]" value="だっちゃん">だっちゃん
        <input type="checkbox" name="aaa[]" value="王子">王子
    </p>
     <p><input type="submit" value="送信"></p>
     <?php
        foreach ($_POST["gengo"] as $value) {
            echo '<input type="hidden" name="gengo[]" value="' . $value . '">';
       }
       foreach ($_POST["bunya"] as $value) {
           echo '<input type="hidden" name="bunya[]" value="' . $value . '">';
      }
        ?>

</form>
  </body>
</html>
