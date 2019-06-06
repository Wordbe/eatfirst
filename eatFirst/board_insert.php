<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$title = $_POST['title'];
$foodtype_no = $_POST['foodtype_no'];
$content = $_POST['content'];

mysqli_query($conn, "set autocommit = 0");	// autocommit 해제.
mysqli_query($conn, "set transation isolation level serializable");	// isolation level 설정.
mysqli_query($conn, "begin");	// begins a transation.

$ret = mysqli_query($conn, "insert into board (title, foodtype_no, content, posted_date) 
							values('$title', '$foodtype_no', '$content', NOW())");
if(!$ret)
{
	mysqli_query($conn, "rollback"); // query 수행 실패. 수행 전으로 rollback.
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "set @cnt = 0");
	mysqli_query($conn, "update recipe
						 set recipe_no = @cnt:=@cnt+1");
	mysqli_query($conn, "commit"); // query 수행 성공. 수행 내역 commit.
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=board_list.php'>";
}

?>

