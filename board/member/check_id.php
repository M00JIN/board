 <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/bootstrap.css">
 <link rel="stylesheet" href="//unpkg.com/bootstrap@4/dist/css/bootstrap.min.css">
  <?php $id = $_REQUEST["id"];
  
  $id_check = str_split($id);
  $id_conform = true;
  
  for($i=0;$i<strlen($id);$i++)  { //아이디 한 글자씩 체크
      $check = ord($id_check[$i]);
      if((($check>=97  && $check <= 122) || $check ==95 || ($check >= 48 && $check<=57)) && strlen($id)>=4){ //a~z , _ , 0~9 , 4글자 이상
          $id_confirm = true;
      }
      else{
          $id_confirm = false;
      }
  }
  
    if(!$id){
     print "아이디를 입력하세요.<p>";
    }
	else if(!$id_confirm){
       print "유효하지 않은 아이디입니다.";
	}
	else {//$id_confirm == true일 때
    
		require_once("../lib/MYDB.php"); 
		$pdo = db_connect();

		try{
		  $sql = "select * from mandu.member where id = ? ";
		  $stmh = $pdo->prepare($sql); 
		  $stmh->bindValue(1,$id,PDO::PARAM_STR); 
		  $stmh->execute(); 
		  $count = $stmh->rowCount();              
		} catch (PDOException $Exception) {
			print "오류: ".$Exception->getMessage();
		}
        
        if($count<1){
            print "사용가능한 아이디입니다.<p>";
        }else{
            print "사용중인 아이디입니다.<p><br>";
        }
    }
       print "<center><button type=\"button\" class=\"btn btn-secondary btn-sm\" onClick=\"self.close()\">닫기</button></center>";

     ?>
