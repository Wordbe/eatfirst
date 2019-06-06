<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<div style="float: left; width: 23%; padding: 10px;">
	<p align="center"><img src="./images/Korean_cuisine.jpg" width="100%"></p>
</div>
<div style="float: left; width: 23%; padding: 10px;">
	<p align="center"><img src="./images/Japanese_cuisine.jpg" width="100%"></p>
</div>
<div style="float: left; width: 23%; padding: 10px;">
	<p align="center"><img src="./images/Chinese_cuisine.jpg" width="100%"></p>
</div>
<div style="float: left; width: 23%; padding: 10px;">
	<p align="center"><img src="./images/MiddleEastern_cuisine.jpg" width="100%"></p>
</div>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *
    		  from restaurant natural join foodtype";
    			
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where restaurant_name like '%$search_keyword%' or
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
            <th>음식점명</th>
            <th>분류</th>
            <th>지역</th>
            <th>메뉴</th>
            <th>배달</th>
            <th>옵션</th>
        </tr>
        </thead>
        <tbody>
        	
        <?php
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
        	
            echo "<tr>";
            echo "<td width='3%'>{$row_index}</td>";
            echo "<td width='10%'><a href='restaurant_detail.php?restaurant_no={$row['restaurant_no']}'>	{$row['restaurant_name']}	</a></td>";
            echo "<td width='6%'>{$row['foodtype_name']}</td>";
            echo "<td width='6%'>{$row['address']}</td>";
            echo "<td width='15%'>{$row['menu']}</td>";
            echo "<td width='6%'>{$row['delivery']}</td>";
            
            echo "<td width='17%'>
                <a href='restaurant_form.php?restaurant_no={$row['restaurant_no']}'><button class='button primary small'>수정</button></a>
                <a href='review_form.php?restaurant_no={$row['restaurant_no']}'><button class='button primary small'>리뷰입력</button></a>
                 <button onclick='javascript:deleteConfirm({$row['restaurant_no']})' class='button danger small'>삭제</button>
                </td>";
                
            echo "</tr>";
            
            $row_index++;
        }
        
        if ($row_index == 1) {
	        echo "<td colspan=7 align=center> 음식점이 존재하지 않습니다. </td>";
	    }
        
        ?>
        
        </tbody>
    </table>
    
    <ul align='right'><a href='restaurant_form.php'><button class='button primary small'>음식점 등록</button></a></ul>
    
    <script>
        function deleteConfirm(restaurant_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "restaurant_delete.php?restaurant_no=" + restaurant_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
