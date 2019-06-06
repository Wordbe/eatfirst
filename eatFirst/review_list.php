<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *
    		  from restaurant natural join review";
    			
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where title like '%$search_keyword%' or
        						   content like '%$search_keyword%'";
    
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
            <th>음식점명</th>
            <th>지역</th>
            <th>배달</th>
            <th>리뷰제목</th>
            <th>평점</th>
            <th>리뷰내용</th>
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
            echo "<td width='15%'>{$row['restaurant_name']}</td>";
            echo "<td width='10%'>{$row['address']}</td>";
            echo "<td width='6%'>{$row['delivery']}</td>";
            echo "<td width='20%'><a href='review_detail.php?review_no={$row['review_no']}'>	{$row['title']}	</a></td>";
            echo "<td width='5%'>{$row['rating']}</td>";
            echo "<td width='20%'>{$row['content']}</td>";
            echo "<td width='15%'>{$row['reviewed_date']}</td>";
            
            echo "<td width='15%'>
                <a href='review_form.php?restaurant_no={$row['restaurant_no']}&review_no={$row['review_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['restaurant_no']}, {$row['review_no']})' class='button danger small'>삭제</button>
                </td>";
                
            echo "</tr>";
            
            $row_index++;
        }
        
        if ($row_index == 1) {
	        echo "<td colspan=6 align=center> 리뷰가 존재하지 않습니다. </td>";
	    }
	    
        ?>
        
        </tbody>
    </table>
    
    
    <script>
        function deleteConfirm(restaurant_no, review_no) {
	            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
	                window.location = "review_delete.php?restaurant_no=" + restaurant_no + "&review_no=" + review_no;
	            }else{   //취소
	                return;
	            }
	        }
    </script>
</div>
<? include("footer.php") ?>
