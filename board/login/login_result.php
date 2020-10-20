<?php
session_start();

$id = $_REQUEST["id"];
$pw = $_REQUEST["pass"];



require_once("../lib/MYDB.php");
$pdo= db_connect();

try{
    $sql = "select * from mandu.member where id=?"; //로그인한 id 정보 가져옴
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1, $id,PDO::PARAM_STR);
    $stmh->execute();
    
    $count = $stmh->rowCount();
    
    
} catch (PDOException $Exception) {
    print "오류 : ".$Exception->getMessage();
}
$row=$stmh->fetch(PDO::FETCH_ASSOC);

if($count<1){
?>

    <script>
        alert("존재하지 않는 아이디입니다.");
        history.back();
    </script>
    
<?php
    } else if(!password_verify($pw, $row["pass"])) {
?>
    <script>
        alert("비밀번호가 일치하지 않습니다.");
        history.back();
    </script>
<?php
    } else{
        
        try{ //접속한 ip 등록, 로그인한 id 세션값 저장
            $pdo->beginTransaction();   
            $sql = "update mandu.member set ip=? where id=?"; 
            $stmh = $pdo->prepare($sql); 
            
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $stmh->bindValue(1,$ip_address, PDO::PARAM_STR);   
            $stmh->bindValue(2,$id, PDO::PARAM_STR); 

            $stmh->execute();
            $pdo->commit(); 

            $_SESSION["ip"]=$_SERVER['REMOTE_ADDR']; 
            $_SESSION["userid"]=$row["id"];
            $_SESSION["name"]=$row["name"];
            $_SESSION["nick"]=$row["nick"]; 

        } catch (PDOException $Exception) {
            $pdo->rollBack();
            print "오류: ".$Exception->getMessage();
        }
    header("Location:../index.php");
    exit;
           
    }
?>