<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$board_no = $_POST['board_no'];
$title = $_POST['title'];
$foodtype_no = $_POST['foodtype_no'];
$content = $_POST['content'];

mysqli_query($conn, "set autocommit = 0");	// autocommit 해제
mysqli_query($conn, "set transation isolation level serializable");	// isolation level 설정
mysqli_query($conn, "begin");	// begins a transation

$ret = mysqli_query($conn, "update board set title = '$title',
											  foodtype_no = $foodtype_no,
											  content = '$content',
											  posted_date = NOW()
							where board_no = $board_no");

if(!$ret)
{
	echo "에러";
	mysqli_query($conn, "rollback"); // query 수행 실패. 수행 전으로 rollback
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    mysqli_query($conn, "commit"); // query 수행 성공. 수행 내역 commit
    echo "<meta http-equiv='refresh' content='0;url=board_list.php'>";
}
?>

