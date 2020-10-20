  <?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

    $num=$_REQUEST["num"];
	$ripple_num=$_REQUEST["ripple_num"];

    require_once("../../lib/MYDB.php");
    $pdo = db_connect();

     try{
       $pdo->beginTransaction();
       $sql = "delete from mandu.text_board_ripple where parent = ? and num= ?"; //게시글 번호, 댓글 번호와 일치하는 댓글 삭제
       $stmh = $pdo->prepare($sql);
       $stmh->bindValue(1,$num,PDO::PARAM_STR);
	   $stmh->bindValue(2,$ripple_num,PDO::PARAM_STR);
       $stmh->execute();
       $pdo->commit();

        header("Location:../view.php?num=$num");
       } catch (Exception $ex) {
                $pdo->rollBack();
                print "오류: ".$Exception->getMessage();
       }
  ?>
