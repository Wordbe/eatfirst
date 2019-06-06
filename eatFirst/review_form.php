<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);


if (array_key_exists("restaurant_no", $_GET) & array_key_exists("review_no", $_GET)) {
    $restaurant_no = $_GET["restaurant_no"];
    $review_no = $_GET["review_no"];
    $query =  "select *
    		   from review
    		   where restaurant_no = $restaurant_no and review_no = $review_no";
    $res = mysqli_query($conn, $query);
    $review = mysqli_fetch_array($res);
    
    if(!$review) {
        msg("리뷰가 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "review_modify.php";
}

else if (array_key_exists("restaurant_no", $_GET)) {
    $restaurant_no = $_GET["restaurant_no"];
    $query =  "select *
    		   from restaurant
    		   where restaurant_no = $restaurant_no";
    $res = mysqli_query($conn, $query);
    $restaurant = mysqli_fetch_array($res);
    
    if(!$restaurant) {
        msg("음식점이 존재하지 않습니다.");
    }
    $mode = "입력";
	$action = "review_insert.php";
}




?>

    <div class="container">
        <form name="review_form" action="<?=$action?>" method="post" class="fullwidth">
        	
            <h3>리뷰 정보 <?=$mode?></h3>
            <br/>
            <p>
	            <input type="hidden" placeholder="음식점 번호 입력" id="restaurant_no" name="restaurant_no" value="<?= $restaurant_no ?>"/>
	            <input type="hidden" placeholder="리뷰 번호 입력" id="review_no" name="review_no" value="<?= $review['review_no'] ?>"/>
	        </p>
            
            <p>
                <label for="title">리뷰 제목</label>
                <input type="text" placeholder="리뷰 제목 입력" id="title" name="title" value="<?=$review['title']?>"/>
            </p>
	        
	        <p>
                <label for="rating">평점</label> <br>
                <input type="radio" name="rating" value=1> ★  
                <input type="radio" name="rating" value=2> ★★ 
                <input type="radio" name="rating" value=3> ★★★ 
                <input type="radio" name="rating" value=4> ★★★★ 
                <input type="radio" name="rating" value=5 checked> ★★★★★ 
            </p>
            
	        <p>
	            <label for="content">내용</label>
	            <textarea placeholder="리뷰 내용 입력" id="content" name="content" rows="10"><?= $review['content'] ?></textarea>
	        </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("title").value == "") {
                        alert ("리뷰 제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("content").value == "") {
                        alert ("내용을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
    
<?php include("footer.php") ?>