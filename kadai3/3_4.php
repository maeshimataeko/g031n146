<?php
echo '<p>好きな言語: ';
foreach( $_POST['gengo'] as $value ){
     echo "{$value}, ";
}
echo '</p>';
echo '<p>興味のある研究分野: ';
foreach( $_POST['bunya'] as $value){
     echo "{$value}, ";
}
echo '</p>';
echo '<p>好きなAAAのメンバー: ';
foreach( $_POST['aaa'] as $value ){
     echo "{$value}, ";
}
echo '</p>';
?>
