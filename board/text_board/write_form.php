  <?php
   session_start(); 
  ?>
  <!DOCTYPE HTML>
  <html>
  <head> 
  <meta charset="utf-8">
 
  <script type="text/javascript" src="./nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
  <link  rel="stylesheet" type="text/css" href="../css/common.css">
  <link  rel="stylesheet" type="text/css" href="../css/text_board.css">
  </head>
 
  <body>
  <div id="wrap">
   
      <?php include "../lib/title.php";?>
  
   <div class="container align-center my-5">

	<form  name="board_form" method="post" action="insert.php" enctype="multipart/form-data"> 
            <div id="write_form">

                <div id="write_row1">
                    <div class="col1">
                         제목 &nbsp;&nbsp; <input type="text" id="greetSubject" name="subject" required>
                    </div>
                </div>

                <div id="write_row2">
                    <div class="col1">
                       작성자 &nbsp; <?=$_SESSION["nick"]?>
                       <?php
                       if(isset($_SESSION["userid"])){
                           if($_SESSION["userid"] == "admin"){?>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;공지사항으로 등록 <input type="checkbox" name="setNotice">
                       <?php    }
                       }
                       ?>
					   <!--&nbsp; &nbsp; 네이버 스마트 에디터 사용 <input type="checkbox" data-toggle="toggle" data-size="xs">-->
                    </div>
                </div>
				
				
                <div class="write_form">
                    <textarea style="overflow-y:scroll; resize:none;" rows="15" cols="150" name="content" id="ir1" required></textarea>
                    <script type="text/javascript">
                        var oEditors = [];
                        nhn.husky.EZCreator.createInIFrame({
                            oAppRef: oEditors,
                            elPlaceHolder: "ir1",
                            sSkinURI: "./nse_files/SmartEditor2Skin.html",
                            fCreator: "createSEditor2"
                        });
                        function submitContents(elClickedObj) {
                            // 에디터의 내용이 textarea에 적용됩니다.
                            oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
                            // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

                            try {
                                elClickedObj.form.submit();
                            } catch(e) {}
                        }
                    </script>
                </div>
				
				<div class="col1"> 이미지파일1   </div>
                <div class="col2"><input type="file" name="upfile[]"></div>
                
                <div class="col1"> 이미지파일2   </div>
                <div class="col2"><input type="file" name="upfile[]"></div>
                
                <div class="col1"> 이미지파일3   </div>
                <div class="col2"><input type="file" name="upfile[]"></div>
                		
                <div id="write_button">
                    <button type="button" class="btn btn-primary" onclick="submitContents(this)">완료</button>
                    &nbsp; <button type="button" class="btn btn-secondary" onclick="history.back()">취소</button>
                </div>
            </div>
        </form>
      
      
   </div> 
  </div>
   <!-- end of wrap -->

  </body>
  </html>
