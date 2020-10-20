<?php
	$id=$_REQUEST["id"];
	$name=$_REQUEST["name"];
	$nick=$_REQUEST["nick"];
	$hp1=$_REQUEST["hp1"];
	$hp2=$_REQUEST["hp2"];
	$hp3=$_REQUEST["hp3"];
	$email1=$_REQUEST["email1"];
	$email2=$_REQUEST["email2"];
	$hp=$hp1."-".$hp2."-".$hp3;
	$email = $email1."@".$email2;
	$regist_day=date("Y-m-d H:i:s");


	require_once ("../lib/MYDB.php");
	$pdo=db_connect();

	$sql = "select * from mandu.member where nick = ? ";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1,$nick,PDO::PARAM_STR); 
    $stmh->execute(); 
    $count = $stmh->rowCount();
	
	if($count!=0){ ?>
        <script>
			alert("사용할 수 없는 닉네임입니다.");
			history.back();
		</script>
		<?php
			
                
    }else{
		try{
			$pdo->beginTransaction();
			$sql = "update mandu.member set nick=?,hp=?,email=?,regist_day=? where id=?";
			$stmh = $pdo->prepare($sql);
			 
			$stmh->bindValue(1,$nick,PDO::PARAM_STR);
			$stmh->bindValue(2,$hp,PDO::PARAM_STR);
			$stmh->bindValue(3,$email,PDO::PARAM_STR);
			$stmh->bindValue(4,$regist_day,PDO::PARAM_STR);
			$stmh->bindValue(5,$id,PDO::PARAM_STR);
				
			$stmh->execute();
			$pdo->commit();
				
			
			header("Location:../index.php");
			exit;
			} catch (PDOException $Exception) {
				$pdo->rollBack();
				print"오류 : ".$Exception->getMessage();
			}
	}
			?>

