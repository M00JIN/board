<?php

function db_connect(){  //DB연결을 함수로 정의
    $db_user ="mglee531";    //추가한 계정이름(사용자명)
    $db_pass ="22E4da638!";     //비밀번호
    $db_host ="mjdatabase.c1c6flfkseeo.ap-northeast-2.rds.amazonaws.com";  
    $db_name ="mandu";
    $db_type ="mysql";
    $dsn ="$db_type:host=$db_host;db_name=$db_name;charset=utf8";

    try{ 
        $pdo=new PDO($dsn,$db_user,$db_pass);  
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
        
    } catch (PDOException $Exception) {  
        die('오류:'.$Exception->getMessage());
    }
    return $pdo;
}
?>