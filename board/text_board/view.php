<?php
  session_start();
  $file_dir = 'data/'; 
  $num=$_REQUEST["num"];

  require_once("../lib/MYDB.php");
  $pdo = db_connect();

	try{
		$sql = "select * from mandu.text_board where num=?";
		$stmh = $pdo->prepare($sql);
		stmh->bindValue(1, $num, PDO::PARAM_STR);
		$stmh->execute();

		while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
			$item_num     = $row["num"];
			$item_id      = $row["id"];
			$item_name    = $row["name"];
			$item_nick    = $row["nick"];
			$item_isNotice = $row["isNotice"];
			$item_subject = str_replace(" ", "&nbsp;", $row["subject"]);
			$item_content = $row["content"];
			$item_date    = $row["regist_day"];
			$item_date    = substr($item_date, 0, 10);
			$item_hit     = $row["hit"];
			$item_content = htmlspecialchars_decode($item_content);
			 
			$image_name[0]   = $row["file_name_0"];
			$image_name[1]   = $row["file_name_1"];
			$image_name[2]   = $row["file_name_2"];
		 
			$image_copied[0] = $row["file_copied_0"];
			$image_copied[1] = $row["file_copied_1"];
			$image_copied[2] = $row["file_copied_2"];

     
			try{
				$pdo->beginTransaction();
			   
				if(!empty($num) && empty($_COOKIE["text_board_".$num])){
				    $sql = "update mandu.text_board set hit=hit+1 where num=?";   // 글 조회수 증가
				    setcookie("text_board_".$num,TRUE,time()+(60*60*24),'/');
				    $stmh = $pdo->prepare($sql);
				    $stmh->bindValue(1, $num, PDO::PARAM_STR);
				    $stmh->execute();
				    $pdo->commit();
			    }
		   
			} catch (PDOException $Exception) {
				$pdo->rollBack();
			    print "오류: ".$Exception->getMessage();
			}
 ?>
 <!DOCTYPE HTML>
 <html>
 <head>
 <meta charset="utf-8">
 <link rel="stylesheet" type="text/css" href="../css/common.css">
 <link rel="stylesheet" type="text/css" href="../css/text_board.css">
 <script>
   function del(href)
    {
      if(confirm("삭제 후 복구가 불가능합니다.\n\n정말 삭제하시겠습니까?")) {
           document.location.href = href;
        }
    }
 </script>
 </head>
 <body>
 <div id="wrap">

  <?php include "../lib/title.php";?>
  
 

    <div class="container align-center my-5">
        

        <div id="view_comment"> &nbsp;</div>
        <div id="view_title">
			<div id="view_title1"><?= $item_subject ?></div>
			<div id="view_title2"><?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?> </div>
		</div>
		
        <div id="view_content">
		<?php
		 $page = $_REQUEST["page"];
		 
			for ($i=0; $i<3; $i++){
			    if ($image_copied[$i]){
					$imageinfo = getimagesize($file_dir.$image_copied[$i]);
					$image_width[$i] = $imageinfo[0];
					$image_height[$i] = $imageinfo[1];
					$image_type[$i]  = $imageinfo[2];
					$img_name = $image_copied[$i];
					$img_name = "data/".$img_name;
					
					if ($image_width[$i] > 500)
							$image_width[$i] = 500;
					   
					  // image 타입 1은 gif 2는 jpg 3은 png
					if($image_type[$i]==1 || $image_type[$i]==2	|| $image_type[$i]==3){
						print "<img src='$img_name' width='$image_width[$i]'><br><br>";
					}
				}
			}
		?><?=$item_content?></div>
        
		
		
		<div id="view_button">
			<a href="list.php?page=<?=$page?>"><button type="button" class="btn btn-secondary">목록</button></a>&nbsp;
		<?php
			  if(isset($_SESSION["userid"])) {
				if($_SESSION["userid"]==$item_id || $_SESSION["userid"]=="admin"){
		?>
			<a href="modify_form.php?num=<?=$num?>"><button type="button" class="btn btn-secondary">수정</button></a>&nbsp;
			<a href="javascript:del('delete.php?num=<?=$num?>')"><button type="button" class="btn btn-danger">삭제</button></a>&nbsp;
			<a href="write_form.php"><button type="button" class="btn btn-primary">글쓰기</button></a>
		<?php  }
			  }
     	?>	
        </div>
 <?php
	
	}
     //댓글
		try{
			$sql = "select * from mandu.text_board_ripple  where parent=$num order by num asc";
			$stmh = $pdo->query($sql);
		} catch (PDOException $Exception) {
			print "오류: ".$Exception->getMessage();
		}
  
  ?>
    <br><br>
    
  <?php
  
		while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
		    $ripple_num     = $row["num"];
		    $ripple_id      = $row["id"];
		    $ripple_date    = $row["regist_day"];
		    $ripple_nick    = $row["nick"];
		    $parent         = $row["parent"];
		    $ripple_content = str_replace("\n", "<br>", $row["content"]);
		    $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
 ?>
       <div>
        <?=$ripple_num?>&nbsp;<b><?=$ripple_nick ?></b>&nbsp;<?=$ripple_date ?>&nbsp;
		<?php
			if(isset($_SESSION["userid"])){
				if($_SESSION["userid"]=="admin" || $_SESSION["userid"]==$ripple_id)
					print "<a href='text_board_ripple/delete_ripple.php?num=$num&ripple_num=$ripple_num'>[삭제]</a>";
			}
		?>
		</div>
	<div><?= $ripple_content ?></div><br>
	
	

    <?php
        }

    } catch (PDOException $Exception) {
		print "오류: ".$Exception->getMessage();
	}

 ?>
	
	<?php
		if(isset($_SESSION["userid"])){ //로그인 했을 때 글 쓸 수 있는 권한 부여
	?>
	<div class="ripple_row">
        <form  name="ripple_form" method="post" action="./text_board_ripple/insert_ripple.php?num=<?=$num?>&ripple_num=<?=$ripple_num?>">
          <div><textarea rows="4" cols="58" name="content" required></textarea></div>
		  <span style="float:left;">▷ <?=$_SESSION["nick"]?></span><button id="write_ripple" type="submit" class="btn btn-primary" onclick="write_ripple()">작성</button>
		</form>
    </div>
	<?php } ?>

</div>
</div>


 </body>
 <script>
	function write_ripple() {
		if(document.getElementById("write_ripple").value=="") {
			alert("내용을 입력하세요.");
			return false;
		}
		else
			document.ripple_form.submit();
		}
 </script>
 </html>
