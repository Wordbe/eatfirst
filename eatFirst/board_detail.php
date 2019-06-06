<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("board_no", $_GET)) {
    $board_no = $_GET["board_no"];
    $query = "select *
    		  from board natural join foodtype
    		  where board_no = $board_no";
    $res = mysqli_query($conn, $query);
    $board = mysqli_fetch_assoc($res);
    if (!$board) {
        msg("게시글이 존재하지 않습니다.");
    }
}
?>

    <div class="container fullwidth">
		
        <h3> <b>제목: <?php echo $board['title']; ?></b> </h3>
        <br>
        
        <p>
            <label for="board_no">게시글 번호</label>
            <input readonly type="text" id="board_no" name="board_no" value="<?= $board['board_no'] ?>"/>
	        </p>
        
        <p>
        	<label for="title">게시글 제목</label>
            <input readonly type="text" id="title" name="title" value="<?= $board['title'] ?>"/>
        </p>
        
        <p>
        	<label for="foodtype_name">음식분류</label>
            <input readonly type="text" id="foodtype_name" name="foodtype_name" value="<?= $board['foodtype_name'] ?>"/>
        </p>
        
        <p>
            <label for="content">내용</label>
            <textarea readonly id="content" name="content" rows="10"><?= $board['content'] ?></textarea>
        </p>

        <p>
            <label for="posted_date">등록일자</label>
            <input readonly type="text" id="posted_date" name="posted_date" value="<?= $board['posted_date'] ?>"/>
        </p>
    </div>
    
<?php include("footer.php") ?>