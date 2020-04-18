<?php
function Delete ($del, $table, $ID){
if (isset($_GET['$del'])) {//Удалем уже существующую запись
    $id = trim($_GET['$del']); 
    $sql = "DELETE FROM" .$table ."WHERE" .$ID ."=?";
    $query = $pdo->prepare($sql);
    $query->execute(array( $id));

$a = 'rrr';
    redirect_to('/index.php');
 return var_dump($a);
    }
}?>