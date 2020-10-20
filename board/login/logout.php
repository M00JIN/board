<?php
error_reporting(E_ALL);

ini_set("display_errors", 1);


require_once("../lib/MYDB.php");
    
	$pdo= db_connect();

	$pdo->beginTransaction();
	$sql = "update mandu.member set ip=NULL where id=?";
	$stmh = $pdo->prepare($sql);
	$stmh->bindValue(1,$id,PDO::PARAM_STR);
	$stmh->execute();
	$pdo->commit();
	
	session_start();		
	session_unset();
	session_destroy();
	header("Location:../index.php")

?>