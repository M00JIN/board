<?php session_start();
 date_default_timezone_set('Asia/Seoul');
?>
<meta charset="utf-8">
<?php
   if(!isset($_SESSION["userid"])) {
?>
  <script>
    alert('로그인 후 이용해 주세요.');
	history.back();
   </script>
<?php
  }
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  
  	//modify_form에서 호출할 경우
	if(isset($_REQUEST["mode"]))  
	   $mode=$_REQUEST["mode"];
	else
	   $mode="";

	if(isset($_REQUEST["num"]))
	  $num=$_REQUEST["num"];
	else
	  $num="";

	//공지사항 등록 체크 여부
	if(isset($_POST["setNotice"])) 
				$isNotice=1;
			else
				$isNotice=0;
			
	$user_id = $_SESSION["userid"];
	$subject=$_REQUEST["subject"];
	$content=$_REQUEST["content"];
 	
	//첨부파일
	$files = $_FILES["upfile"];   
	$count = count($files["name"]);

	//$upload_dir = 'C:\xampp\htdocs\text_board\data\\';   //물리적 저장위치
	$upload_dir = './data/';

	for ($i=0; $i<$count; $i++){
		$upfile_name[$i]     = $files["name"][$i];
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];
		$upfile_type[$i]     = $files["type"][$i];
		$upfile_size[$i]     = $files["size"][$i];
		$upfile_error[$i]    = $files["error"][$i];
		//파일명,확장자 구분
		$file = explode(".", $upfile_name[$i]);
		$file_name = $file[0];
		$file_ext  = $file[1];

		if (!$upfile_error[$i]) {
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name."_".$i;
			$copied_file_name[$i] = $new_file_name.".".$file_ext;
			$uploaded_file[$i] = $upload_dir.$copied_file_name[$i];
			
								
				if ( ($upfile_type[$i] != "image/gif") && ($upfile_type[$i] != "image/jpeg")){
					print(" <script>
							  alert('JPG와 GIF 이미지 파일만 업로드 가능합니다.');
							  history.back();
							</script>");
					exit;
				}
				
				if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i])) {
					print("<script>
							alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
						   
						  </script>");
					 exit;
				}
		}
	}


	require_once("../lib/MYDB.php");
	$pdo = db_connect();


	//수정모드
	if ($mode=="modify"){
	   $num_checked = count($_REQUEST['del_file']); //삭제 체크된 아이템 개수
	   $position = $_REQUEST['del_file'];
		
		// 체크된 아이템 삭제
		for($i=0; $i<$num_checked; $i++) { 
			$index = $position[$i];
			$del_ok[$index] = "y";
		}

	    try{	
			$sql = "select * from mandu.text_board where num=?";  
			$stmh = $pdo->prepare($sql);
			$stmh->bindValue(1,$num,PDO::PARAM_STR);
			$stmh->execute();
			$row = $stmh->fetch(PDO::FETCH_ASSOC);
	    } catch (PDOException $Exception) {
			  $pdo->rollBack();
			  print "오류: ".$Exception->getMessage();
		}
		
		for ($i=0; $i<$count; $i++){
			$field_org_name = "file_name_".$i;
			$field_real_name = "file_copied_".$i;
			$org_name_value = $upfile_name[$i];
			$org_real_value = $copied_file_name[$i];
			
			if ($del_ok[$i] == "y") {
				$delete_field = "file_copied_".$i;
				$delete_name = $row[$delete_field];
				$delete_path = $upload_dir.$delete_name;
				unlink($delete_path);

                try {
					$pdo->beginTransaction();
					$sql = "update mandu.text_board set $field_org_name = ?, $field_real_name = ?  where num=?";
					$stmh = $pdo->prepare($sql);
					$stmh->bindValue(1, $org_name_value, PDO::PARAM_STR);
					$stmh->bindValue(2, $org_real_value, PDO::PARAM_STR);
					$stmh->bindValue(3, $num, PDO::PARAM_STR);
					$stmh->execute();
					$pdo->commit();
                } catch (PDOException $Exception) {
					  $pdo->rollBack();
					  print "오류: ".$Exception->getMessage();
				}
			}   else{
					if (!$upfile_error[$i])	{
						try {
							$pdo->beginTransaction();
							$sql = "update mandu.text_board set $field_org_name = ?, $field_real_name = ?  where num=?";
							$stmh = $pdo->prepare($sql);
							$stmh->bindValue(1, $org_name_value, PDO::PARAM_STR);
							$stmh->bindValue(2, $org_real_value, PDO::PARAM_STR);
							$stmh->bindValue(3, $num, PDO::PARAM_STR);
							$stmh->execute();
							$pdo->commit();
						} catch (PDOException $Exception) {
							$pdo->rollBack();
							print "오류: ".$Exception->getMessage();
						}
					}		
				}
		}
		//수정 내용 등록
		$pdo->beginTransaction();
		$sql = "update mandu.text_board set subject=?, content=?,isNotice=? where num=?";
		$stmh = $pdo->prepare($sql);

		try { 
			$stmh->bindValue(1, $subject, PDO::PARAM_STR);
			$stmh->bindValue(2, $content, PDO::PARAM_STR);
			$stmh->bindValue(3, $isNotice, PDO::PARAM_STR);
			$stmh->bindValue(4, $num, PDO::PARAM_STR);
			$stmh->execute();
			$pdo->commit();

			header("Location:./list.php?page=1");
		} catch (PDOException $Exception) {
			 $pdo->rollBack();
			 print "오류: ".$Exception->getMessage();
		}

	} else {
		    try{
				$pdo->beginTransaction();
				$sql = "insert into mandu.text_board(id,name,nick,subject,content,regist_day,hit,isNotice, ";
				$sql .= " file_name_0, file_name_1, file_name_2,file_name_3,file_name_4, file_copied_0,file_copied_1,file_copied_2,file_copied_3,file_copied_4) ";
				$sql .= "values(?, ?, ?, ?, ?, now(), 0,?,?,?,?,?,?,?,?,?,?,?)";
				$stmh = $pdo->prepare($sql);
				$stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);
				$stmh->bindValue(2, $_SESSION["name"], PDO::PARAM_STR);
				$stmh->bindValue(3, $_SESSION["nick"], PDO::PARAM_STR);
				$stmh->bindValue(4, $subject, PDO::PARAM_STR);
				$stmh->bindValue(5, $content, PDO::PARAM_STR);
				$stmh->bindValue(6, $isNotice, PDO::PARAM_STR);
				$stmh->bindValue(7, $upfile_name[0], PDO::PARAM_STR);
				$stmh->bindValue(8,$upfile_name[1], PDO::PARAM_STR);
				$stmh->bindValue(9, $upfile_name[2], PDO::PARAM_STR);
				$stmh->bindValue(10, $upfile_name[3], PDO::PARAM_STR);
				$stmh->bindValue(11, $upfile_name[4], PDO::PARAM_STR);
				$stmh->bindValue(12, $copied_file_name[0], PDO::PARAM_STR);
				$stmh->bindValue(13, $copied_file_name[1], PDO::PARAM_STR);
				$stmh->bindValue(14, $copied_file_name[2], PDO::PARAM_STR);
				$stmh->bindValue(15, $copied_file_name[3], PDO::PARAM_STR);
				$stmh->bindValue(16, $copied_file_name[4], PDO::PARAM_STR);

			    $stmh->execute();
			    $pdo->commit();
				header("Location:./list.php?page=1");
			} catch (PDOException $Exception) {
				$pdo->rollBack();
				print "오류: ".$Exception->getMessage();
			}
	}
?>
