 <?php

   date_default_timezone_set("Asia/Seoul");
   error_reporting(E_ALL);

   ini_set("display_errors", 1);
 ?>
 <!DOCTYPE HTML>
 <html>
 <head>
 <meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="../css/common.css">
 <link rel="stylesheet" type="text/css" href="../css/text_board.css">
 </head>

 <?php

  require_once("../lib/MYDB.php");
  $pdo = db_connect();
 ?>

  <body>
  <?php

 if(isset($_REQUEST["mode"]))
     $mode=$_REQUEST["mode"];
  else
     $mode="";

  if(isset($_REQUEST["search"]))   // search 쿼리스트링 값 할당 체크
    $search=$_REQUEST["search"];
  else
    $search="";

  if(isset($_REQUEST["find"]))
    $find=$_REQUEST["find"];
  else
    $find="";

  if($mode=="search"){
    if(!$search){
  ?>
    <script>
        alert('검색할 단어를 입력해 주세요!');
        history.back();
    </script>
  <?php
    }
   $sql="select * from mandu.text_board where $find like '%$search%' order by num desc";
  } else {
   $sql="select * from mandu.text_board order by num desc";
  }
  try{
    $stmh = $pdo->query($sql);
    $count=$stmh->rowCount();


  ?>
  <div id="wrap">


         <?php include "../lib/title.php";?>



    <div class="container">
	
	<div> <br>▷ 총 <?= $count ?> 개의 게시물이 있습니다.</div>
	
      
	<table class="table table-hover">
	<thead>
	<tr>
		<th style="width: 10%">번호</th>
		<th style="width: 30%">제목</th>
		<th style="width: 7%"> </th>
		<th style="width: 10%">작성자</th>
		<th style="width: 20%">날짜</th>
		<th style="width: 10%">조회수</th>
	</tr>
  </thead>




  <tbody>
  <?php  // 글 목록 출력

    
    $notice_sql = "select * from mandu.text_board where isNotice = 1 order by num desc ";
    

   //$showList = ($page-1)*$countList;
    $day_1 = 60*60*24;
    $day_2 = 60*60*24*2;

    $Nstmh = $pdo->query($notice_sql);
    $noticeCount=$Nstmh->rowCount();

    $page =$_REQUEST["page"];
    $countList = 15; //한 페이지에 출력된 게시물 수
    $countPage = 10; // 하단에 표시될 총 페이지 수 (1~10)
    $totalPage = (int)(($count-$noticeCount) / ($countList - $noticeCount)); // 페이지 수
	
    if((int)(($count-$noticeCount) % ($countList-$noticeCount)) > 0 || $count == 0){
        $totalPage++;  //마지막 페이지에 15개 미만의 나머지 게시물 출력을 위함
    }
    if($totalPage < $page){
        $page = $totalPage;
    }
    
	$startPage = (int)(($page - 1) / 10) * 10 + 1; //1~10,11~20,...
    $endPage = (int)($startPage + $countPage) - 1;

    if($endPage > $totalPage){
        $endPage = $totalPage;
    }

   $count_cast = (int)($countList-$noticeCount);
   $showList = ($page-1)*($countList-$noticeCount);

    while($row = $Nstmh->fetch(PDO::FETCH_ASSOC)) {
        $item_num=$row["num"];
        $item_id=$row["id"];
        $item_name=$row["name"];
        $item_nick=$row["nick"];
        $item_hit=$row["hit"];
        $item_date=$row["regist_day"];
		
		if($row["file_copied_0"])
			$item_thumbnail=$row["file_copied_0"];
		else if($row["file_copied_1"])
			$item_thumbnail=$row["file_copied_1"];
		else
			$item_thumbnail=$row["file_copied_2"];
		
        $item_new=$item_date;

        if((strtotime("now") - strtotime($item_new)) < $day_1){
            $item_date=substr($item_date, 11, 5);
        } else {
            $item_date=substr($item_date, 0, 10);
        }
        
		$item_isNotice = $row["isNotice"];
        $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
  ?>


    <tr class="bg-notice">
      <td><?= $item_num ?></td>
      <td class="text-left">
			  <a href="view.php?num=<?=$item_num?>&page=<?=$page?>"><?= $item_subject ?></a>
				<?php

				  if((strtotime("now") - strtotime($item_new)) < $day_2){
				?>
						<img src='../img/new.png'/>
				<?php }
				?>
	  </td>
	  <td>
				<?php
				if($item_thumbnail){ ?>
				<img src="./data/<?=$item_thumbnail?>" width='30' height='30' id="thumbnail">
			<?php   }   ?>
	  </td>
	  
      <td style="width : 15%"><?= $item_nick ?></td>
      <td><?= $item_date ?></td>
      <td><?= $item_hit ?></td>
    </tr>



  <?php
    }
  ?>

    <?php  // 글 목록 출력

   
    $sql = "select * from mandu.text_board where isNotice != 1 order by num desc limit $showList,$count_cast";
   

    $stmh = $pdo->query($sql);
        
	while($row = $stmh->fetch(PDO::FETCH_ASSOC)) { /* limit 15개씩 출력, "(page-1)*15"*/
        $item_num=$row["num"];
        $item_id=$row["id"];
        $item_name=$row["name"];
        $item_nick=$row["nick"];
        $item_hit=$row["hit"];
        $item_date=$row["regist_day"];
		
		if($row["file_copied_0"])
			$item_thumbnail=$row["file_copied_0"];
		
		else if($row["file_copied_1"])
			$item_thumbnail=$row["file_copied_1"];

		else
			$item_thumbnail=$row["file_copied_2"];

        $item_new = $item_date;

        if((strtotime("now") - strtotime($item_new)) < $day_1){
            $item_date=substr($item_date, 11, 5);
        } else {
			$item_date=substr($item_date, 0, 10);
        }



        $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);

  ?>

    <tr>
		<td><?= $item_num ?></td>
		<td class="text-left"><a href="view.php?num=<?=$item_num?>&page=<?=$page?>"><?= $item_subject ?></a>
        <?php

          if((strtotime("now") - strtotime($item_new)) < $day_2){
          ?>
          <img src='../img/new.png'/>
          <?php
          }
		  ?>
		</td>
		<td class="no-padding">
		<?php
			if($item_thumbnail){ ?>
				<img src="./data/<?=$item_thumbnail?>" width='30' height='30' id="thumbnail">
    <?php   }   ?>
		</td>
		
		<td><?= $item_nick ?></td>
		<td><?= $item_date ?></td>
		<td><?= $item_hit ?></td>
    </tr>


  <?php
    }
  ?>
</tbody>
</table>
<div class="row">
<div class="col-md-8 mx-auto" align="center">

 <?php
          if($page > 1){
            if($mode=="search"){
  ?>
              <a href="list.php?mode=search&page=1">처음&nbsp;&nbsp;</a>
  <?php
             } else{
  ?>
              <a href="list.php?page=1">처음&nbsp;&nbsp;</a>
  <?php
            }
          }
          if($page > 1){
              if($mode=="search"){
  ?>
              <a href="list.php?mode=search&page=<?=$page-1?>">이전</a>
  <?php
              } else {
  ?>
              <a href="list.php?page=<?=$page-1?>">이전</a>

  <?php
              }
          }

  ?>


	
	  <?php
		  for($iCount= $startPage;$iCount <= $endPage;$iCount++){

			  if($iCount == $page){
				  print("&nbsp;&nbsp;"."<b>".$iCount."</b>");
			  }
			  else{
				  if($mode=="search"){

	  ?>
				  &nbsp;&nbsp;<a href="list.php?mode=search&page=<?=$iCount?>"><?=$iCount?></a>
	  <?php
				  } else {
	  ?>
				  &nbsp;&nbsp;<a href="list.php?page=<?=$iCount?>"><?=$iCount?></a>
			  <?php
				  }
			  }
		  }
	  ?>
      <?php
          if($page < $totalPage){
              if($mode=="search"){
      ?>
                  <a href="list.php?mode=search&page=<?=$page+1?>">&nbsp;다음&nbsp;&nbsp;</a>
              <?php
              } else {
              ?>
              <a href="list.php?page=<?=$page+1?>">&nbsp;다음&nbsp;&nbsp;</a>
      <?php
              }
          }
          if($page!=$totalPage){
              if($mode=="search"){
      ?>
                  <a href="list.php?mode=search&page=<?=$totalPage?>">끝</a>
      <?php
              } else {
      ?>
             <a href="list.php?page=<?=$totalPage?>">끝</a>
      <?php
              }
          }


  ?>

</div>


<div class="button">

<?php


	if(isset($_SESSION["userid"])){
	?>
	<a href="write_form.php"><button type="button" class="btn btn-primary">글쓰기</button></a>
	<?php
	}

}
catch (PDOException $Exception) {
print "오류: ".$Exception->getMessage();
}
?>
</div>
</div> <!--end of page_num-->
</div><!-- end of container -->

  </div> <!-- end of wrap -->


  </body>
  </html>
