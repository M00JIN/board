  <?php
    $num=$_REQUEST["num"];
        
    require_once("../lib/MYDB.php");
    $pdo = db_connect();
        
     try{
       $pdo->beginTransaction();
       $sql = "delete from mandu.text_board where num = ?";   
       $stmh = $pdo->prepare($sql);
       $stmh->bindValue(1,$num,PDO::PARAM_STR);
       $stmh->execute();   
       $pdo->commit();
                
        header("Location:./list.php?page=1");
       } catch (Exception $ex) {
                $pdo->rollBack();
                print "오류: ".$Exception->getMessage();
       }
  ?>
