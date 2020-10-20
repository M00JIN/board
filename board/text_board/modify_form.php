 <?php
  session_start(); 
         
  $num = $_REQUEST["num"];
 
  require_once("../lib/MYDB.php"); 
  $pdo = db_connect(); 
   
	try{
		$sql = "select * from mandu.text_board where num = ? ";
		$stmh = $pdo->prepare($sql); 
		$stmh->bindValue(1,$num,PDO::PARAM_STR); 
		stmh->execute(); 
		$count = $stmh->rowCount();              
     
     
		if($count<1){  
			print "검색결과가 없습니다.<br>";
		}else {
       
		    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
				$isNotice = $row["isNotice"];
				$item_subject = $row["subject"];
				$item_content = $row["content"];
				$item_content = htmlspecialchars_decode($item_content);
				$item_file_0 = $row["file_name_0"];
				$item_file_1 = $row["file_name_1"];
				$item_file_2 = $row["file_name_2"];
				$copied_file_0 = $row["file_copied_0"];
				$copied_file_1 = $row["file_copied_1"];
				$copied_file_2 = $row["file_copied_2"];
      
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
    
 
            

	 
	<form  name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>" enctype="multipart/form-data"> 
            <div id="write_form">

                <div id="write_row1">
                    <div class="col1">
                         제목 &nbsp;&nbsp; <input type="text" id="greetSubject" name="subject" value="<?=$item_subject?>" required>
                    </div>
                </div>

                <div id="write_row2">
                    <div class="col1">
                       작성자 &nbsp; <?=$_SESSION["nick"]?>
                       <?php
                       if(isset($_SESSION["userid"])){
                           if($_SESSION["userid"] == "admin"){?>
                       &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;공지사항으로 등록 <input type="checkbox" name="setNotice" <?php if($isNotice == 1) echo "checked"?>>
                       <?php 
                            }
                       }
                       
                        
                         ?>
                    </div>
                </div>

                <div class="write_form">
                    <textarea style="overflow-y:scroll; resize:none;" rows="15" cols="150" name="content" id="ir1" required><?=$item_content?></textarea>
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
                <?php 	if ($item_file_0)
	         {
                ?>
                <div class="delete_ok">
                <?=$item_file_0?> 파일이 등록되어 있습니다. 
                <input type="checkbox" name="del_file[]" value="0"> 삭제</div>
                <?php  	} ?>
                
                <div class="col1"> 이미지파일2   </div>
                <div class="col2"><input type="file" name="upfile[]"></div>
                <?php 	if ($item_file_1)
	         {
                ?>
                <div class="delete_ok">
                <?=$item_file_1?> 파일이 등록되어 있습니다. 
                <input type="checkbox" name="del_file[]" value="0"> 삭제</div>
                <?php  	} ?>
                
                <div class="col1"> 이미지파일3   </div>
                <div class="col2"><input type="file" name="upfile[]"></div>
                <?php 	if ($item_file_2)
	         {
                ?>
                <div class="delete_ok">
                <?=$item_file_2?> 파일이 등록되어 있습니다. 
                <input type="checkbox" name="del_file[]" value="0"> 삭제</div>
                <?php  	} ?>
				

                <div id="write_button">
                    <button type="button" class="btn btn-primary" onclick="submitContents(this)">완료</button>
                    &nbsp; <button type="button" class="btn btn-secondary" onclick="history.back()">취소</button>
                </div>
            </div>
        </form>
      
     
   </div> 
  </div>
    
 <?php
			}
		}
	}	catch (PDOException $Exception) {
       print "오류: ".$Exception->getMessage();
    }
  
 ?>
 </body>
 </html>
 
 <script>
   
 </script>