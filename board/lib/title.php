<html>

    <head>
        <meta charset="UTF-8">
        <title>Mandu</title>
		   <link rel="stylesheet" type="text/css" href="../css/common.css">
		   <link rel="stylesheet" type="text/css" href="../css/login.css">
		   <link rel="stylesheet" href="../css/bootstrap.css">
		   <link rel="stylesheet" href="//unpkg.com/bootstrap@4/dist/css/bootstrap.min.css">
		   <link href="//cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
		   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet"/>
		   <style>
			a:hover{
				text-decoration: none;
			}
			</style>
		<?php
			include_once "../login/multi_login.php";
		?>
    </head>
    <body>
        <div class="loginBackground">
		
                <div class="loginWindow"> <!--반투명 배경-->
                </div>
                <div class="loginContent"> <!--로그인창--> 
                    <form name="login_form" method="post" action="../login/login_result.php">
                        <div id="login_msg">환영합니다!
                        </div>
                        <div id="input_box">
                            <input type="text" name="id" placeholder=" 아이디" required><br><br>
                            <input type="password" name="pass" placeholder=" 비밀번호" required><br>
                        </div>
                        <div id="button_box">
							<button type="button" class="btn btn-primary mr-auto" onclick ="document.login_form.submit()">로그인</button>
							&nbsp;&nbsp;
							<button type="button" class="btn btn-secondary" onclick ="closeWindow()">취소</button>
						</div>
                    </form>
                </div>

                    
        </div>
  



        <!--상단바-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="../text_board/list.php?page=1">게시판</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExample05">
			
				<ul class="text-right list-inline navbar-nav ml-auto">
			  
					<?php
						if(!isset($_SESSION["userid"])) {
						?>
							<li class="nav-item"><a class="nav-link" style="cursor: pointer" onclick="openWindow()">로그인</a></li>
							<li class="nav-item"><a class="nav-link"  href="../member/insertForm.php">회원가입</a></li>
						<?php
						}
						else {
						?>
							<li class="nav-item text-primary mb-0 mt-2"><h5><?=$_SESSION["nick"]?></h5></li>
							<li class="nav-item"><a class="nav-link"  href="../login/logout.php">로그아웃</a></li>
							<li class="nav-item"><a class="nav-link" href="../member/updateForm_check.php?id=<?=$_SESSION["userid"]?>">정보수정</a></li>

						<?php
						}
						?>
				</ul>		
			</div>
		</nav> 



	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script src='//unpkg.com/jquery@3/dist/jquery.min.js'></script>
	<script src='//unpkg.com/popper.js@1/dist/umd/popper.min.js'></script>
	<script src='//unpkg.com/bootstrap@4/dist/js/bootstrap.min.js'></script>
	<script src="//cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/js/bootstrap4-toggle.min.js"></script>
    </body>
    <script>
    function openWindow(){
        var Window = document.getElementsByClassName("loginBackground");

        for(var i=0;i<Window.length;i+=1) {
        Window[i].style.display="block";
        }
    }
    function closeWindow() {
        var Window = document.getElementsByClassName("loginBackground");

        for(var i=0;i<Window.length;i+=1) {
        Window[i].style.display="none";
        }
    }
</script>
</html>
