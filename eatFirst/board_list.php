<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *
    		  from board natural join foodtype";
    			
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where title like '%$search_keyword%' or
        						   foodtype_name like '%$search_keyword%'";
    
    }
    
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>음식분류</th>
            <th>제목</th>
            <th>등록일자</th>
            <th>옵션</th>
        </tr>
        </thead>
        
        <tbody>
        <?php
        
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
        	
            echo "<tr>";
            echo "<td width='3%'>{$row_index}</td>";
            echo "<td width='7%'>{$row['foodtype_name']}</td>";
            echo "<td width='20%'><a href='board_detail.php?board_no={$row['board_no']}'>	{$row['title']}	</a></td>";
            echo "<td width='15%'>{$row['posted_date']}</td>";
            
            echo "<td width='15%'>
                <a href='board_form.php?board_no={$row['board_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['board_no']})' class='button danger small'>삭제</button>
                </td>";
                
            echo "</tr>";
            
            $row_index++;
        }
        
        if ($row_index == 1) {
	        echo "<td colspan=5 align=center> 게시글이 존재하지 않습니다. </td>";
	    }
        ?>
        
        </tbody>
    </table>
    
    <ul align='right'><a href='board_form.php'><button class='button primary small'>게시글 등록</button></a></ul>
    
    <script>
        function deleteConfirm(board_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "board_delete.php?board_no=" + board_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
