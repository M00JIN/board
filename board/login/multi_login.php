<?php
	

    require_once("../lib/MYDB.php");
    
	$pdo= db_connect();
	
    if(isset($_SESSION['userid'])) {
        try{
        $sql = "select ip from mandu.member where id=?";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $_SESSION["userid"],PDO::PARAM_STR);
        $stmh->execute();
		
        
		$row = $stmh->fetch(PDO::FETCH_ASSOC);
		$ip = $row["ip"];
		
			if($ip != $_SESSION["ip"]) { //세션의 ip가 갱신되었을 경우 세션 해제
				
				session_unset();
				
				
				echo "<script>window.alert('다른 곳에서 로그인되었습니다.');
					location.href='../index.php';</script>";
				exit;
			}
		}catch (PDOException $Exception) {
            print "오류 : ".$Exception->getMessage();
            }  
    }