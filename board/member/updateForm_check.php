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
    <body style="height:100%">
        <?php
        include "../lib/title.php";
        $id = $_REQUEST["id"];
        
        require_once("../lib/MYDB.php");
        $pdo = db_connect();
        
        ?>
		
		<div class="container text-center">
			<br>
			<br>
			<br>
			<div>
				본인 확인을 위해 비밀번호를 입력해주세요.
				<br>
				<br>
				
					<form name="check_form" method="post" action="./updateForm.php?id=<?=$id?>">
						<input type="password" name="pass" placeholder=" 비밀번호" required>
						<span>
							<button type="button" class="btn btn-primary btn-sm" onclick="document.check_form.submit()">확인</button>
							<button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">취소</button>
						</span>
					</form>
			</div>
			
		</div>
    </body>
</html>
