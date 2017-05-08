<html>
  <head>
    <meta charset="utf-8">
  </head>

  <body>
    <form action="3_3.php" method="POST">
     <p>興味のある研究分野を選択してください（複数回答可）:
         <input type="checkbox" name="bunya[]" value="教育">教育
        <input type="checkbox" name="bunya[]" value="観光">観光
        <input type="checkbox" name="bunya[]" value="農業">農業
        <input type="checkbox" name="bunya[]" value="医療">医療
    </p>
     <p><input type="submit" value="送信"></p>

     <?php
        foreach ($_POST["gengo"] as $value) {
            echo '<input type="hidden" name="gengo[]" value="' . $value . '">';
       }
        ?>


</form>
  </body>
</html>
