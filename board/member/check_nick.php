 <meta charset="UTF-8">
 <link rel="stylesheet" href="../css/bootstrap.css">
 <link rel="stylesheet" href="//unpkg.com/bootstrap@4/dist/css/bootstrap.min.css">
  <?php $nick = $_REQUEST["nick"];
    if(!$nick){
     print "닉네임을 입력하세요.<p>";
    }
	else{
		 require_once("../lib/MYDB.php"); 
		 $pdo = db_connect();

		try{
			$sql = "select * from mandu.member where nick = ? ";
			$stmh = $pdo->prepare($sql); 
			$stmh->bindValue(1,$nick,PDO::PARAM_STR); 
			$stmh->execute(); 
			$count = $stmh->rowCount();              
		} catch (PDOException $Exception) {
			print "오류: ".$Exception->getMessage();
		}
        
        if($count<1){
            print "사용가능한 닉네임입니다.<p>";
                
        }else{
            print "사용중인 닉네임입니다.<br>다른 닉네임을 사용해 주세요.<p>";
        }
    }
    
	print "<center><button type=\"button\" class=\"btn btn-secondary btn-sm\" onClick=\"self.close()\">닫기</button></center>";

     ?>
