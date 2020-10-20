<?php
  session_start();
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<script>
function check_id(w,h){
		var xPos = (document.body.offsetWidth/2) - (w/2); // 가운데 정렬
		xPos += window.screenLeft; // 듀얼 모니터일 때
		var yPos = (document.body.offsetHeight/2) - (h/2);
		
		window.open("check_id.php?id="+document.member_form.id.value,"IDcheck","width=" + w + ",height=" + h + ",left=" + xPos + ",top=" + yPos + ", scrollbars=no,resizable=yes");
}
function check_nick(w,h){
		var xPos = (document.body.offsetWidth/2) - (w/2); // 가운데 정렬
		xPos += window.screenLeft; // 듀얼 모니터일 때
		var yPos = (document.body.offsetHeight/2) - (h/2);
		
		window.open("check_nick.php?nick="+document.member_form.nick.value,"NICKcheck","width=" + w + ",height=" + h + ",left=" + xPos + ",top=" + yPos + ", scrollbars=no,resizable=yes");
}

function check_input(){
     if(document.member_form.pass.value != document.member_form.pass_confirm.value){ //비밀번호 불일치 시
            alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요."); 
            document.member_form.pass.focus();
            document.member_form.pass.select();
            return;
         }
	 if(!document.member_form.name.value ){ //이름 공백일 시
            alert("이름을 입력하세요."); 
            document.member_form.name.focus();
            return;
         }
	 if(!document.member_form.nick.value ){ //닉네임 공백일 시 
            alert("닉네임을 입력하세요."); 
            document.member_form.nick.focus();
            return;
         }
	 if(!document.member_form.hp2.value || !document.member_form.hp3.value ){ //휴대폰 번호 공백일 시
            alert("휴대폰 번호를 입력하세요."); 
            document.member_form.hp1.focus();
            return;
         }

      document.member_form.submit();
}

</script>
</head>
<body>
        <?php include "../lib/title.php"; ?>
        
			<div class="container">
				<br>
				<br>
				<br>
				<form name="member_form" method="post" action="insertPro.php"> 
                
                <div id="form_join">
                        <div id="join1">
                            <ul>

                             <li>* 아이디</li>
                             <li>* 비밀번호</li>
							 <li>* 비밀번호 확인</li>
                             <li>* 이름</li>
                             <li>* 닉네임</li>
                             <li>* 휴대폰</li>
                             <li>&nbsp;&nbsp;이메일</li>
                            </ul>
                        </div>
				
                        <div id="join2">
                            <ul>
								<li>
									<span id="id1">
										<input type="text"  name= "id" required>
										&nbsp;<button type="button" class="btn btn-primary btn-sm" onclick="check_id(300,60)">중복확인</button>
									</span>
                                  
								</li>
								<li><input type="password" name="pass" required> 8~16자리의 영문, 숫자, 특수문자 필수</li>
								<li><input type="password" name="pass_confirm" required></li>
								<li><input type="text" name="name" required ></li>

								
								<li>
                                <span>
                                    <input type="text" name="nick" required >
                                     &nbsp;<button type="button" class="btn btn-primary btn-sm" onclick="check_nick(300,60)">중복확인</button>
                                 </span>
								</li>
								<li>
                                 <input type="text" class="hp" name="hp1" value= "010" >
                              - <input type="text" class="hp" name="hp2"> - 
                                <input type="text" class="hp" name="hp3">
								</li>
								<li>
                                  <input type="text" id="email1" name="email1"> @ <input type="text" name="email2">
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
      

 </body>
 </html>


