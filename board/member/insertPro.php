 <?php
error_reporting(E_ALL);

ini_set("display_errors", 1);

  $id = $_REQUEST["id"];
  $pass = $_REQUEST["pass"];
  $name = $_REQUEST["name"];
  $nick = $_REQUEST["nick"];
  $hp1 = $_REQUEST["hp1"];
  $hp2 = $_REQUEST["hp2"];
  $hp3 = $_REQUEST["hp3"];
  $email1 = $_REQUEST["email1"];
  $email2 = $_REQUEST["email2"];
  $hp = $hp1."-".$hp2."-".$hp3;
  $email = $email1."@".$email2;
  $ip = $_SESSION["ip"];
  
function passwordCheck($_str){ //패스워드 유효성 검사
    $pw = $_str;
    $num = preg_match('/[0-9]/u', $pw);
    $eng = preg_match('/[a-z]/u', $pw);
    $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);
 
    if(strlen($pw) < 8 || strlen($pw) > 16){
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

	if ($result[0] == false){
		?><script>
			alert("<?=$result[1]?>");
			history.back();
		</script>
		<?php
		exit;
	}

    //정규식으로 수정 요망
    $email_check = str_split($email); //이메일 유효성 검사
    $email_confirm = true;
    $flag = 0;
    for($i=0;$i<strlen($email);$i++){ //한 글자씩 검사
		$check = ord($email_check[$i]);
		
		if((($check>=97  && $check <= 122) || $check ==64 || $check == 46 || ($check >= 48 && $check<=57))){
			$flag++; //유효한 문자일 때 flag++
		}  
    }
     if($email!=""){ 
		 if(strlen($email) != $flag){ //이메일 주소 길이와 유효한 문자의 갯수가 맞지 않을 때
			$email_confirm = false;
		 }
	 }

    if(!$email_confirm){
      ?><script>
            alert("잘못된 이메일 형식입니다.");
            history.back();
        </script>
<?php } else {
       
				$email = $email1."@".$email2; 

				if($result[0] ==true)
					$encrypted_password = password_hash($pass, PASSWORD_DEFAULT); //패스워드 해싱
			  
				require_once("../lib/MYDB.php");  
				$pdo = db_connect();   
 
			try{
				$pdo->beginTransaction();   
				$sql = "insert into mandu.member VALUES(?, ?, ?, ?, ?, ?, now(),?)"; 
				$stmh = $pdo->prepare($sql); 
				$stmh->bindValue(1, $id, PDO::PARAM_STR);  
				$stmh->bindValue(2, $encrypted_password, PDO::PARAM_STR);   
				$stmh->bindValue(3, $name, PDO::PARAM_STR);
				$stmh->bindValue(4, $nick, PDO::PARAM_STR);
				$stmh->bindValue(5, $hp, PDO::PARAM_STR);
				$stmh->bindValue(6, $email, PDO::PARAM_STR);
				$stmh->bindValue(7, $regist_day, PDO::PARAM_STR);
				$stmh->bindValue(8, $ip,PDO::PARAM_STR);
			 
				$stmh->execute();
				$pdo->commit(); 
				 
				header("Location:../index.php");
			   } catch (PDOException $Exception) {
					 $pdo->rollBack();
					 print "오류: ".$Exception->getMessage();
			   }
	}
 ?>
