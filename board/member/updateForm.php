
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<script>
function check_id() {
      window.open("check_id.php?id="+document.member_form.id.value, "IDcheck", "left=200, top=200, width=300,height=60, scrollbars=no, resizable=yes");
}

function check_nick(w,h) {
		var xPos = (document.body.offsetWidth/2) - (w/2); // 가운데 정렬
		xPos += window.screenLeft; // 듀얼 모니터일 때
		var yPos = (document.body.offsetHeight/2) - (h/2);
		
		window.open("check_nick.php?nick="+document.member_form.nick.value,"NICKcheck","width=" + w + ",height=" + h + ",left=" + xPos + ",top=" + yPos + ", scrollbars=no,resizable=yes");
    }
	
function check_input() {
     if(!document.member_form.hp2.value || !document.member_form.hp3.value ) {
            alert("휴대폰 번호를 입력하세요"); 
            document.member_form.hp1.focus();
            return;
         }
	 if(!document.member_form.nick.value) {
			alert("닉네임을 입력하세요");
			document.member_form.nick.focus();
			return;
	 }
	 

      document.member_form.submit();
    }
</script>
</head>

    <?php
        $id = $_REQUEST["id"];
        $pw = $_REQUEST["pass"];
        
        
        require_once("../lib/MYDB.php");
        $pdo = db_connect();
        
        try{
            $sql = "select * from mandu.member where id = ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1,$id,PDO::PARAM_STR);
            $stmh->execute();
            $count = $stmh->rowCount();
			
			
        }
        catch(PDOException $Exception) {
            print "오류 : ".$Exception->getMessage();
        }
        
        
        if($count<1){
            print "검색결과가 없습니다.<br>";
        }
        
        
        while($row = $stmh->fetch(PDO::FETCH_ASSOC)){

			
            $hp = explode("-", $row["hp"]); //hp 분할
            
            $hp2 = $hp[1];
            $hp3 = $hp[2];
            
            $email=explode("@",$row["email"]); //email 분할
            $email1=$email[0];
            $email2=$email[1];
            
			if(!password_verify($pw, $row["pass"])){ //패스워드 불일치 시
        ?>
            <script>
                alert("비밀번호가 일치하지 않습니다.");
                history.back();
            </script>
        <?php }
         ?>
    
            
        
<body>   
    
        
        <?php include "../lib/title.php"; ?>
        
			<div class="container">
				<br>
				<br>
				<br>
				<form name="member_form" method="post" action="updatePro.php?id=<?=$id?>"> 
                
                <div id="form_join">
                        <div id="update1">
                            <ul>
                             <li>&nbsp;&nbsp;아이디</li>
                             <li>&nbsp;&nbsp;비밀번호</li>
                             <li>&nbsp;&nbsp;이름</li>
                             <li>* 닉네임</li>
                             <li>* 휴대폰</li>
                             <li>&nbsp;&nbsp;이메일</li>
                            </ul>
                        </div>
				
                        <div id="update2">
                            <ul>
								<li>
									<span id="id1">
										<?=$id?>
									</span>
                                  
								</li>
								<li><a href="change_pass.php?id=<?=$id?>" style="cursor: pointer"><b>[비밀번호 변경]</b></a></li>
								<li>
									<span>
										<?=$_SESSION["name"]?>
									</span>
								</li>
								<li>
                                <span>
                                    <input type="text" name="nick" value="<?=$_SESSION["nick"]?>" required >
                                </span>
                                 <span>
                                     &nbsp;<button type="button" class="btn btn-primary btn-sm" onclick="check_nick(300,60)">중복확인</button>
                                 </span>
								</li>
								<li>
                                 <input type="text" class="hp" name="hp1" value= "010" >
                              - <input type="text" class="hp" name="hp2" value="<?= $hp2 ?>"> - 
                                <input type="text" class="hp" name="hp3" value="<?= $hp3 ?>">
								</li>
								<li>
                                  <input type="text" id="email1" name="email1" value="<?=$email1?>"> @ <input type="text" name="email2" value="<?= $email2 ?>">
                              </li>
                            </ul>
                        </div>
                
                <div id="must"> * 는 필수 입력항목입니다.</div>
                </div>
                <div class="button">
                    <a href="#"><button type="button" class="btn btn-primary" onclick="check_input()">저장</button></a>&nbsp;&nbsp;
                    <a href="../index.php"><button type="button" class="btn btn-secondary">취소</button></a>
                </div>
            </form>
       
       </div>
        <?php } ?>
</body>