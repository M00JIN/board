<?php
  session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

    
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/common.css">
        <link rel="stylesheet" type="text/css" href="../css/member.css">
        <title></title>
    </head>
    <body>
        <?php
        include "../lib/title.php";
		if($_SESSION["userid"] != $_REQUEST["id"]){ //url 조작 방지
        ?>
        <script>
                alert("다른 아이디의 비밀번호를 변경할 수 없습니다.");
                history.back();
        </script>
		<?php }

        $id = $_REQUEST["id"];
		
        require_once("../lib/MYDB.php");
        $pdo = db_connect();
        
        ?>
		<div class="container text-center">
			<div>
			<br>
			<br>
			<br>
				변경하실 비밀번호를 입력해주세요.
				<form name="change_form" method="post" action="./change_pass_confirm.php?id=<?=$id?>">
							
					<div>
						<br>
						<input type="password" name="pass" id="check_box" placeholder=" 비밀번호" required>
						<br>
						<br>
						<input type="password" name="pass_confirm" id="check_box" placeholder=" 비밀번호 재입력" required>
						<br>
						<br>
						<button class="btn btn-primary" onclick ="check_input()">변경</button>&nbsp;&nbsp;
						<a href="../index.php"><button type="button" class="btn btn-secondary">취소</button></a>
					</div>

				</form>
			</div>
		</div>
    </body>
<script>
    function check_input()
    {
       if((document.change_form.pass.value !== document.change_form.pass_confirm.value) || document.change_form.pass.value === null) {
            alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
			history.back();
            document.change_form.pass.focus();
            document.change_form.pass.select();
			return;
         }
		
      document.change_form.submit();
		
	}
	
</script>
</html>
