 <?php
 
error_reporting(E_ALL);

ini_set("display_errors", 1);


  $id = $_REQUEST["id"];
  $pass = $_REQUEST["pass"];
  
  
  
  function passwordCheck($_str){ //패스워드 유효성 검사
			$pw = $_str;
			$num = preg_match('/[0-9]/u', $pw);
			$eng = preg_match('/[a-z]/u', $pw);
			$spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);
		 
			if(strlen($pw) < 8 || strlen($pw) > 16)	{
				return array(false,"비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 8자리 ~ 최대 16자리 이내로 입력해주세요.");
				exit;
			}
		 
			if(preg_match("/\s/u", $pw) == true){
				return array(false, "비밀번호는 공백없이 입력해주세요.");
				exit;
			}
		 
			if( $num == 0 || $eng == 0 || $spe == 0){
				return array(false, "영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
				exit;
			}
		 
			return array(true);
		}
		
		$result = passwordCheck("$pass");

	if ($result[0] == false){ ?> 
		<script>
		alert("<?=$result[1]?>");
		history.back();
		</script>
		<?php
		exit;
        }
		
		if($result[0] ==true){
			$encrypted_password = password_hash($pass, PASSWORD_DEFAULT); //패스워드 해싱
        }
		
		require_once("../lib/MYDB.php");  
		$pdo = db_connect();   
 
  try{
	 
      $pdo->beginTransaction();   
      $sql = "update mandu.member set pass=? where id=?"; 
      $stmh = $pdo->prepare($sql); 
       
      $stmh->bindValue(1, $encrypted_password, PDO::PARAM_STR); //해싱 패스워드 등록
      $stmh->bindValue(2, $id, PDO::PARAM_STR); 
     
 
     $stmh->execute();
     $pdo->commit(); 
     
     header("Location:../index.php");
	 
   } catch (PDOException $Exception) {
         $pdo->rollBack();
         print "오류: ".$Exception->getMessage();
   }
 ?>
