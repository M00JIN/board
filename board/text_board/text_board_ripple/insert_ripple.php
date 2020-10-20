  <?php session_start(); ?>
  <meta charset="utf-8">
  <?php
     if(!isset($_SESSION["userid"])) {
  ?>
    <script>
         alert('로그인 후 이용해 주세요.');
	 history.back();
     </script>
  <?php
        }
  $num = $_REQUEST["num"];
  $ripple_num_Now= $_REQUEST["ripple_num"];
  $content=$_REQUEST["content"];

  require_once("../../lib/MYDB.php");
  $pdo = db_connect();

    try{
		$sql = "select num from mandu.text_board_ripple where parent=$num order by num desc";
		$stmh = $pdo->query($sql);
		while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
			$ripple_num = $row["num"];
		
			if($ripple_num_Now == $ripple_num){
				$ripple_num_Now = $ripple_num_Now += 1; //마지막 댓글 다음 번호 부여
			}
		}
		
		$pdo->beginTransaction();
		$sql = "insert into mandu.text_board_ripple(parent,id, name, nick, content, regist_day,num)";
		$sql.= "values(?, ?, ?, ?, ?,now(),?)";
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(1, $num, PDO::PARAM_STR);
		$stmh->bindValue(2, $_SESSION["userid"], PDO::PARAM_STR);  
		$stmh->bindValue(3, $_SESSION["name"], PDO::PARAM_STR);
		$stmh->bindValue(4, $_SESSION["nick"], PDO::PARAM_STR);
		$stmh->bindValue(5, $content, PDO::PARAM_STR);
		$stmh->bindValue(6, $ripple_num_Now,PDO::PARAM_STR);
		$stmh->execute();
		$pdo->commit();

    header("Location:../view.php?num=$num");
    } catch (PDOException $Exception) {
         $pdo->rollBack();
       print "오류: ".$Exception->getMessage();
    }
  ?>
