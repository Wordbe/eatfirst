<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "board_insert.php";

if (array_key_exists("board_no", $_GET)) {
    $board_no = $_GET["board_no"];
    $query =  "select *
    		   from board natural join foodtype
    		   where board_no = $board_no";
    $res = mysqli_query($conn, $query);
    $board = mysqli_fetch_array($res);
    
    if(!$board) {
        msg("게시판이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "board_modify.php";
}

$foodtypes = array();

$query = "select * 
		  from foodtype";
		  
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $foodtypes[$row['foodtype_no']] = $row['foodtype_name'];
}
?>

    <div class="container">
        <form name="board_form" action="<?=$action?>" method="post" class="fullwidth">
        	
            <h3>게시판 정보 <?=$mode?></h3>
            <br/>
            <p>
	            <input type="hidden" placeholder="게시판 번호 입력" id="board_no" name="board_no" value="<?= $board['board_no'] ?>"/>
	        </p>
            
            <p>
                <label for="title">제목</label>
                <input type="text" placeholder="제목 입력" id="title" name="title" value="<?=$board['title']?>"/>
            </p>
            
	        <p>
                <label for="foodtype_no">음식 분류</label>
                <select name="foodtype_no" id="foodtype_no">
                    <option value="-1">선택</option>
                    <?php
                        foreach($foodtypes as $number => $name) {
                            if($number == $restaurant['foodtype_no']){
                                echo "<option value='{$number}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$number}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
	        <p>
	            <label for="content">내용</label>
	            <textarea placeholder="내용 입력" id="content" name="content" rows="10"><?= $board['content'] ?></textarea>
	        </p>
            

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("title").value == "") {
                        alert ("제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("foodtype_no").value == "-1") {
                        alert ("음식점 분류를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("content").value == "") {
                        alert ("내용을 입력해 주십시오"); return false;
                    return true;
                }
            </script>

        </form>
    </div>
    
<?php include("footer.php") ?>