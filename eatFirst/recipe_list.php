<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<p align="center"><img src="./images/요리법.jpg" width="35%"></p>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *
    		  from recipe natural join foodtype";
    			
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where recipe_name like '%$search_keyword%' or
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
            <th>요리법명</th>
            <th>분류</th>
            <th>옵션</th>
        </tr>
        </thead>
        <tbody>
        	
        <?php
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
        	
            echo "<tr>";
            echo "<td width='3%'>{$row_index}</td>";
            echo "<td width='10%'><a href='recipe_detail.php?recipe_no={$row['recipe_no']}'>	{$row['recipe_name']}	</a></td>";
            echo "<td width='6%'>{$row['foodtype_name']}</td>";
            
            echo "<td width='10%'>
                <a href='recipe_form.php?recipe_no={$row['recipe_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['recipe_no']})' class='button danger small'>삭제</button>
                </td>";
                
            echo "</tr>";
            
            $row_index++;
        }
        
        if ($row_index == 1) {
	        echo "<td colspan=5 align=center> 요리법 존재하지 않습니다. </td>";
	    }
        
        ?>
        
        </tbody>
    </table>
    
    <ul align='right'><a href='recipe_form.php'><button class='button primary small'>요리법 등록</button></a></ul>
    
    <script>
        function deleteConfirm(recipe_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "recipe_delete.php?recipe_no=" + recipe_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
