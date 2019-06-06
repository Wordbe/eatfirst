﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$recipe_no = $_GET['recipe_no'];

mysqli_query($conn, "set autocommit = 0");	// autocommit 해제
mysqli_query($conn, "set transation isolation level serializable");	// isolation level 설정
mysqli_query($conn, "begin");	// begins a transation

$ret = mysqli_query($conn, "delete from recipe where recipe_no = $recipe_no");



if(!$ret)
{
	mysqli_query($conn, "rollback"); // query 수행 실패. 수행 전으로 rollback
	msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "set @cnt = 0");
	mysqli_query($conn, "update recipe
						 set recipe_no = @cnt:=@cnt+1");
	mysqli_query($conn, "commit"); // query 수행 성공. 수행 내역 commit
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=recipe_list.php'>";
}

?>

