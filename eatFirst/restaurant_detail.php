<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("restaurant_no", $_GET)) {
    $restaurant_no = $_GET["restaurant_no"];
    
    // for restaurant
    $query = "select *
    		  from restaurant natural join foodtype
    		  where restaurant_no = $restaurant_no";
    $res = mysqli_query($conn, $query);
    $restaurant = mysqli_fetch_assoc($res);
    if (!$restaurant) {
        msg("음식점이 존재하지 않습니다.");
    }
    
    // for review
    $review_query = "select * 
    				from restaurant natural join review 
    				where restaurant_no = $restaurant_no";
    $review_res = mysqli_query($conn, $review_query);
}
?>

    <div class="container fullwidth">
        <h3> <b><?php echo $restaurant['restaurant_name']; ?></b>에 오신 것을 환영합니다! </h3>
        <br>
        
        <p>
            <label for="restaurant_no">음식점 번호</label>
            <input readonly type="text" id="restaurant_no" name="restaurant_name" value="<?= $restaurant['restaurant_no'] ?>"/>
	        </p>
        
        <p>
            <label for="restaurant_name">음식점 이름</label>
            <input readonly type="text" id="restaurant_name" name="restaurant_name" value="<?= $restaurant['restaurant_name'] ?>"/>
        </p>
        
        <p>
            <label for="foodtype_name">음식점 분류</label>
            <input readonly type="text" id="foodtype_name" name="foodtype_name" value="<?= $restaurant['foodtype_name'] ?>"/>
        </p>
        
        <p>
            <label for="address">주소</label>
            <input readonly type="text" id="address" name="address" value="<?= $restaurant['address'] ?>"/>
        </p>

        <p>
            <label for="menu">메뉴</label>
            <input readonly type="text" id="menu" name="menu" value="<?= $restaurant['menu'] ?>"/>
        </p>
        
        <p>
            <label for="description">음식점 소개</label>
            <textarea readonly id="description" name="description" rows="10"><?= $restaurant['description'] ?></textarea>
        </p>

        <p>
            <label for="delivery">배달가능 여부</label>
            <input readonly type="text" id="delivery" name="delivery" value="<?= $restaurant['delivery'] ?>"/><br><br>
        </p>
    
    
    
    
    
	    <h3> <b> 리뷰 </h3><br><br>
	    
	    <table class="table table-striped table-bordered">
	        <thead>
	        <tr>
	            <th>No.</th>
	            <th>리뷰제목</th>
	            <th>평점</th>
	            <th>내용</th>
	            <th>등록일자</th>
	            <th>옵션</th>
	        </tr>
	        </thead>
	        
	        <tbody>
	        <?php
	        
		    
	        $row_index = 1;
	        while ($row = mysqli_fetch_array($review_res)) {
	        	
	            echo "<tr>";
	            echo "<td width='3%'>{$row_index}</td>";
	            echo "<td width='20%'><a href='review_detail.php?restaurant_no={$row['restaurant_no']}'>	{$row['title']}	</a></td>";
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
    
    
<?php include("footer.php") ?>